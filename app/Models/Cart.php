<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'total',
    ];

    // Relación: un carrito tiene muchos items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relación: carrito pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
