<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $products = Product::whereIn('id', [3, 1, 2])->get();
        $products = Product::all();
        $cartCount = CartController::getCartCount();

        return view('shop.home', compact('products', 'cartCount'));
    }

}
