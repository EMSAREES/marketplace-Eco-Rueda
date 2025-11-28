<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

     // 🔥 Relación con carrito
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // 🔥 Relación con producto (la que te falta)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calcular subtotal automático
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
        });
    }
}
