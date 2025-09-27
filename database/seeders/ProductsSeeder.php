<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $productsData = [
            // Ensemble Nocturna Gris
            [
                'name' => 'Ensemble Nocturna Gris',
                'slug' => 'ensemble-nocturna-gris',
                'main_image_front' => 'images/hoodie_gray_front.png',
                'main_image_back' => 'images/jogging_gray_front.png',
                'description' => 'Ensemble incluant le hoodie et le jogging. Livraison offerte',
                'price' => 110.00, // prix réduit par rapport à l'achat séparé
            ],
            // Hoodie Nocturna Gris
            [
                'name' => 'Hoodie Nocturna Gris',
                'slug' => 'hoodie-nocturna-gris',
                'main_image_front' => 'images/hoodie_gray_front.png',
                'main_image_back' => null,
                'description' => 'Hoodie confortable avec le logo Nocturna.',
                'price' => 55.00,
            ],
            // Jogging
            [
                'name' => 'Jogging Nocturna Gris',
                'slug' => 'jogging-nocturna-gris',
                'main_image_front' => 'images/jogging_gray_front.png',
                'main_image_back' => 'images/jogging_gray_back.png',
                'description' => 'Jogging confortable avec le logo Nocturna.',
                'price' => 55.00,
            ],
        ];

        foreach ($productsData as $data) {
            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            $sizes = ['S', 'M', 'L', 'XL'];
            foreach ($sizes as $size) {
                $product->sizes()->updateOrCreate(['size' => $size]);
            }
        }
    }
}
