<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', // si lo llenas automáticamente
        'image_path',
        'order',
        'is_primary',
    ];

    /**
     * Relación con Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Obtener URL completa de la imagen
     */
    public function getUrl()
    {
        return asset($this->image_path); // ya incluye 'images/products/filename.png'
    }


}
