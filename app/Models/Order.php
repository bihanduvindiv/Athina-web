<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;

class Order extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned for checkout
    protected $fillable = [
        'user_id',
        'product_id',  // Required by database schema
        'quantity',    // Required by database schema
        'customer_name',
        'customer_email', 
        'customer_phone',
        'shipping_address',
        'total_amount',
        'status',
        'payment_status',
        'order_items'
    ];

    // Relationship: Order belongs to a User (optional for guest checkout)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Order has one Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Cast order_items as array for easy handling
    protected $casts = [
        'order_items' => 'array',
        'total_amount' => 'decimal:2'
    ];
}
