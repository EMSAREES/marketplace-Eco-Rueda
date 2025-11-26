<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id', 'name', 'description', 'price', 'stock',
        'material', 'color', 'image', 'image_2', 'image_3', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relaciones
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Obtener imagen destacada
    public function getFeaturedImage()
    {
        return $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
    }
    

    // Métodos
    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function decreaseStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

}
