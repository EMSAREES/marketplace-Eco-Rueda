<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Todas las compras del usuario
    public function history()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->with('items.product', 'payment')
            ->orderBy('id', 'desc')
            ->get();

        return view('orders.history', compact('orders'));
    }

    // Detalles de una compra
    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('customer_id', Auth::id())
            ->with('items.product', 'payment')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
