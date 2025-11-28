<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class CheckoutController extends Controller
{
    // ============================================
    // Mostrar formulario de checkout
    // ============================================
    public function index()
    {
        $user = Auth::user();

        // Asegurarse que el usuario tiene carrito
        $cart = $user->cart;
        // dd($cart);
        if (!$cart || $cart->items()->count() == 0) {
            return redirect()->route('products.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        return view('checkout.index', compact('cart'));
    }

    // ============================================
    // Procesar pago con Stripe
    // ============================================
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_country' => 'required|string',
            'shipping_postal_code' => 'required|string',
        ]);

        $user = Auth::user();
        $cart = $user->cart->items;

        if ($cart->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'El carrito está vacío.'
            ], 400);
        }

        try {
            // actualizar direcion
            $user->updateProfile([
                'address'      => $request->shipping_address,
                'city'         => $request->shipping_city,
                'state'        => $request->shipping_state,
                'country'      => $request->shipping_country,
                'postal_code'  => $request->shipping_postal_code,
            ]);

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $lineItems = [];
            foreach ($cart as $item) {
                $product = $item->product;

                if (!$product || !$product->stripe_price_id) {
                    return response()->json([
                        'success' => false,
                        'message' => "Producto {$product->name} no configurado correctamente."
                    ], 400);
                }

                if ($product->stock < $item->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "No hay suficiente stock para {$product->name}."
                    ], 400);
                }

                $lineItems[] = [
                    'price' => $product->stripe_price_id,
                    'quantity' => $item->quantity,
                ];
            }

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'line_items' => $lineItems,
                'metadata' => [
                    'user_id' => $user->id,
                    'shipping_address' => $request->shipping_address,
                    'shipping_city' => $request->shipping_city,
                    'shipping_state' => $request->shipping_state,
                    'shipping_country' => $request->shipping_country,
                    'shipping_postal_code' => $request->shipping_postal_code,
                ],
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.index'),
            ]);

            return response()->json([
                'success' => true,
                'url' => $session->url
            ]);

        } catch (\Exception $e) {
            Log::error("Error Stripe: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error procesando pago: ' . $e->getMessage()
            ], 500);
        }
    }


    // ============================================
    // Procesar compra después del pago
    // ============================================
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('products.index')
                ->with('error', 'Sesión inválida.');
        }

        $user = Auth::user();
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::retrieve($sessionId);
            $cart = $user->cart->items;
            $cartT = $user->cart;

            if ($cart->count() == 0) {
                return redirect()->route('products.index')
                    ->with('error', 'No hay carrito para procesar.');
            }

            $order = Order::create([
                'customer_id' => $user->id,
                'total' => $cartT->total,
                'status' => 'paid',
                'shipping_name' => $user->name,
                'shipping_email' => $user->email,
                'shipping_phone' => $user->phone ?? '',
                'shipping_address' => $session->metadata->shipping_address,
                'shipping_city' => $session->metadata->shipping_city,
                'shipping_state' => $session->metadata->shipping_state,
                'shipping_country' => $session->metadata->shipping_country,
                'shipping_postal_code' => $session->metadata->shipping_postal_code,
            ]);




            $totalOrder = 0;

            foreach ($cart as $item) {
                // dd($item->quantity);
                $product = $item->product;
                // dd($product);
                OrderItem::create([
                    'order_id'   => $order->id,        // id de la orden
                    'product_id' => $item->product_id, // id del producto
                    'vendor_id'  => $product->vendor_id, // vendedor dueño del producto
                    'quantity'   => $item->quantity,   // cantidad en el carrito
                    'price'      => $item->price,      // precio al momento de la compra
                    'subtotal'   => $item->subtotal,   // subtotal calculado en el carrito
                ]);


                $product->stock -= $item->quantity;
                $product->save();
                $totalOrder++;
            }

            // dd($totalOrder);



            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'payment_method' => 'Stripe',
                'payment_status' => 'Pagado',
                'transaction_id' => $session->payment_intent,
            ]);

            // Vaciar carrito
            $cartController = new CartController();
            $cartController->clear();


            // return view('checkout.success');
            return view('checkout.success', compact('order'));

        } catch (\Exception $e) {
            Log::error("Error Checkout Success: " . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'Error procesando orden.');
        }
    }

}
