<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;

class ProductSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL'];

        // Récupérer tous les produits existants
        $products = Product::all();

        foreach ($products as $product) {
            foreach ($sizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                ]);
            }
        }
    }
}
