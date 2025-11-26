<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    // Dashboard Vendor
    public function dashboard()
    {
        $user = Auth::user();

        // Ordenar productos del más nuevo al más viejo
        $products = $user->products()->orderBy('created_at', 'desc')->get();

        // Ordenar órdenes igual (si quieres)
        $orders = $user->orderItems()
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('order_id');

        return view('vendor.dashboard', compact('products', 'orders'));
    }

}
