<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $openingDate = Carbon::parse(config('app.opening_date'))
            ->setTimezone(config('app.timezone'));
        $now = Carbon::now()->setTimezone(config('app.timezone'));

        if ($now->lt($openingDate)) {
            // Passe le timestamp en millisecondes côté JS
            return view('coming-soon', [
                'openingDateTimestamp' => $openingDate->timestamp * 1000
            ]);
        } else {
            $products = Product::all();
            $cartCount = CartController::getCartCount();

            return view('shop.home', compact('products', 'cartCount'));
        }
    }
}