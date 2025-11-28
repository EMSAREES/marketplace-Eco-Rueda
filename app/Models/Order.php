<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id', 'total', 'status', 'shipping_name',
        'shipping_email', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_state', 'shipping_country', 'shipping_postal_code'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }


    // Métodos
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function markAsPaid()
    {
        $this->update(['status' => 'paid']);
    }
}
