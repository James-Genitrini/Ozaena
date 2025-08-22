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
            // 1️⃣ Bundle en premier
            [
                'name' => 'Bundle Kimono + T-shirt',
                'slug' => 'bundle-kimono-tshirt',
                'main_image_front' => 'images/bundle_front.png', // image du bundle
                'main_image_back' => 'images/bundle_back.png',
                'description' => 'Bundle incluant le Kimono Japonais et le T-shirt Tokyo à prix spécial.',
                'price' => 145.00, // prix réduit par rapport à l'achat séparé
            ],
            // 2️⃣ Kimono Japonais
            [
                'name' => 'Kimono Japonais',
                'slug' => 'kimono-japonais',
                'main_image_front' => 'images/japon_front.png',
                'main_image_back' => 'images/japon_back.png',
                'description' => 'Un magnifique kimono japonais traditionnel.',
                'price' => 120.00,
            ],
            // 3️⃣ T-shirt Tokyo
            [
                'name' => 'T-shirt Tokyo',
                'slug' => 'tshirt-tokyo',
                'main_image_front' => 'images/tokyo_front.png',
                'main_image_back' => 'images/tokyo_back.png',
                'description' => 'T-shirt stylé inspiré de Tokyo.',
                'price' => 35.00,
            ],
        ];

        foreach ($productsData as $data) {
            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            $sizes = ['XS', 'S', 'M', 'L', 'XL'];
            foreach ($sizes as $size) {
                $product->sizes()->updateOrCreate(['size' => $size]);
            }
        }
    }
}
