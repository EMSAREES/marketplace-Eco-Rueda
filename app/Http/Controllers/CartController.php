<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Obtener carrito del usuario
    private function getUserCart()
    {
        $user = Auth::user();


        // Crear carrito si no existe
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total' => 0]
        );

        return $cart;
    }

    // Mostrar página del carrito
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = $this->getUserCart();
        // $items = $cart->items()->with('product')->get();
        $items = $cart->items()->with(['product.primaryImage'])->get();

        return view('cart.index', compact('items', 'cart'));
    }

    // Agregar producto
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($productId);
        $cart = $this->getUserCart();

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        $newQuantity = $request->quantity;
        if ($cartItem) {
            $newQuantity += $cartItem->quantity;
        }

        if ($newQuantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => "Solo hay {$product->stock} unidades disponibles."
            ], 400);
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $newQuantity,
                'subtotal' => $newQuantity * $cartItem->price
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'subtotal' => $product->price * $request->quantity
            ]);
        }

        // 🔥 recalcular total del carrito
        $this->updateCartTotal($cart);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cartItems' => $cart->items()->with('product')->get(),
            'cartTotal' => $cart->total,
            'cartCount' => $cart->items()->count(),
        ]);
    }


    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        try {
            $cart = $this->getUserCart();

            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $id)
                ->first();

            if (!$item) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
            }

            $product = Product::findOrFail($id);
            $action = $request->action;

            if ($action === 'increase') {
                if ($item->quantity >= $product->stock) {
                    return response()->json(['success' => false, 'message' => 'Stock insuficiente'], 400);
                }
                $item->quantity++;
            } elseif ($action === 'decrease') {
                if ($item->quantity <= 1) {
                    $item->delete();
                } else {
                    $item->quantity--;
                }
            }

            if ($item->exists) {
                $item->subtotal = $item->quantity * $item->price;
                $item->save();
            }

            $this->updateCartTotal($cart);

            return response()->json([
                'success' => true,
                'cartItems' => $cart->items()->with('product')->get(),
                'cartTotal' => $cart->total,
                'cartCount' => $cart->items()->count(),
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Remover producto completamente
    public function remove($id)
    {
        try {
            $cart = $this->getUserCart();

            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $id)
                ->delete();

            $this->updateCartTotal($cart);

            return response()->json([
                'success' => true,
                'cartItems' => $cart->items()->with('product')->get(),
                'cartTotal' => $cart->total,
                'isEmpty' => $cart->items()->count() === 0,
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Vaciar carrito
    public function clear()
    {
        try {
            $cart = $this->getUserCart();

            CartItem::where('cart_id', $cart->id)->delete();

            $cart->update(['total' => 0]);

            return response()->json([
                'success' => true,
                'message' => 'Carrito vaciado',
                'cartCount' => 0,
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Recalcular total del carrito
    private function updateCartTotal($cart)
    {
        $total = $cart->items()->sum('subtotal');
        $cart->update(['total' => $total]);
    }
}
