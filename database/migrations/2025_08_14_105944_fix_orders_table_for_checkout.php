<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make user_id and product_id nullable to support guest checkout and multi-product orders
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('product_id')->nullable()->change();
            
            // Remove quantity column as it's now handled in order_items JSON
            $table->dropColumn('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverse the changes
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreignId('product_id')->nullable(false)->change();
            $table->integer('quantity')->default(1);
        });
    }
};
