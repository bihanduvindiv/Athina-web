<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample products with USD prices
        $products = [
            [
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation',
                'price' => 99.99, // USD
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smartwatch with heart rate monitor',
                'price' => 249.99, // USD
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Adjustable aluminum laptop stand for ergonomic working',
                'price' => 45.50, // USD
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with precision tracking',
                'price' => 29.99, // USD
            ],
            [
                'name' => 'USB-C Hub',
                'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, and SD card reader',
                'price' => 59.99, // USD
            ],
            [
                'name' => 'Portable Charger',
                'description' => '20000mAh portable power bank with fast charging',
                'price' => 39.99, // USD
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
