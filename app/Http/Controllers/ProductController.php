<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $stocks = $product->stocks;
        $images = $product->images;

        return view('product.show', [
            'product' => $product,
            'stocks' => $stocks,
            'images' => $images,
        ]);
    }
}