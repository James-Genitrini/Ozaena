<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $images = $product->images;
        $sizes = $product->sizes;
        
        return view('product.show', [
            'product' => $product,
            'images' => $images,
            'sizes' => $sizes,
        ]);
    }
}