<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'stripe_payment_id', 'amount',
        'status', 'payment_method', 'response'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'response' => 'json'
    ];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Métodos
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
        $this->order->markAsPaid();
    }
}
