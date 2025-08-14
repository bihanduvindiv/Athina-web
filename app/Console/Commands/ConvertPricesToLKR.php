<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class ConvertPricesToLKR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:convert-to-lkr {--rate=320 : USD to LKR exchange rate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all product prices from USD to LKR';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $exchangeRate = (float) $this->option('rate');
        
        $this->info("Converting product prices from USD to LKR...");
        $this->info("Exchange rate: 1 USD = {$exchangeRate} LKR");
        
        $products = Product::all();
        $convertedCount = 0;
        
        if ($products->isEmpty()) {
            $this->warn('No products found in the database.');
            return;
        }
        
        $this->info("Found {$products->count()} products to convert.");
        
        foreach ($products as $product) {
            $oldPrice = $product->price;
            $newPrice = round($oldPrice * $exchangeRate, 2);
            
            $product->update(['price' => $newPrice]);
            
            $this->line("✓ {$product->name}: \${$oldPrice} → LKR {$newPrice}");
            $convertedCount++;
        }
        
        $this->newLine();
        $this->info("Successfully converted {$convertedCount} product prices from USD to LKR!");
        $this->info("Exchange rate used: 1 USD = {$exchangeRate} LKR");
    }
}
