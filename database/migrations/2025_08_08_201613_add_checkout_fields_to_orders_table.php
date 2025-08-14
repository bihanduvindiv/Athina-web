<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add checkout fields to orders table
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Customer information for checkout
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('shipping_address')->nullable();
            
            // Order totals and items
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->json('order_items')->nullable();
            
            // Payment status
            $table->string('payment_status')->default('pending');
            
            // Note: user_id and product_id will remain as they are for now
            // We'll handle nullable values in the controller logic
        });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'customer_email', 
                'customer_phone',
                'shipping_address',
                'total_amount',
                'order_items',
                'payment_status'
            ]);
        });
    }
};
