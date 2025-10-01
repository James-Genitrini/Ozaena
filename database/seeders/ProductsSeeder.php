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
            // Hoodie Nocturna Gris
            [
                'name' => 'Hoodie Nocturna Gris',
                'slug' => 'hoodie-nocturna-gris',
                'main_image_front' => 'images/hoodie_gray_front.png',
                'main_image_back' => null,
                'description' => 'Hoodie confortable de la collection Capsule 00 en version grise.',
                'price' => 55.00,
            ],
            // Jogging
            [
                'name' => 'Jogging Nocturna Gris',
                'slug' => 'jogging-nocturna-gris',
                'main_image_front' => 'images/jogging_gray_front.png',
                'main_image_back' => 'images/jogging_gray_back.png',
                'description' => 'Jogging confortable de la collection Capsule 00 en version grise.',
                'price' => 55.00,
            ],
            [
                'name' => 'Hoodie Nocturna Noir',
                'slug' => 'hoodie-nocturna-noir',
                'main_image_front' => 'images/hoodie_black_front.png',
                'main_image_back' => null,
                'description' => 'Hoodie confortable de la collection Capsule 00 en version noire.',
                'price' => 55.00,
            ],
            // Jogging
            [
                'name' => 'Jogging Nocturna Noir',
                'slug' => 'jogging-nocturna-noir',
                'main_image_front' => 'images/jogging_black_front.png',
                'main_image_back' => 'images/jogging_black_back.png',
                'description' => 'Jogging confortable de la collection Capsule 00 en version noire.',
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

        $product = Product::where('slug', 'ensemble-nocturna-gris')->first();

        if ($product) {
            $product->images()->create([
                'image_path' => 'images/jogging_gray_back.png',
            ]);
        }

        $product = Product::where('slug', 'ensemble-nocturna-noir')->first();

        if ($product) {
            $product->images()->create([
                'image_path' => 'images/jogging_black_back.png',
            ]);
        }

    }
}
