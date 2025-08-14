<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned for checkout
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_status'
    ];

    // Relationship: Payment belongs to an Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Cast amount as decimal for proper handling
    protected $casts = [
        'amount' => 'decimal:2'
    ];
}
