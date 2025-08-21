<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $ordersCount = Order::count();
        $productsCount = Product::count();
        return view('admin.dashboard', compact('ordersCount', 'productsCount'));
    }

    public function orders()
    {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function products()
    {
        $products = Product::take(3)->get();
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.create-product');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Product::create($request->only(['name', 'stock', 'price']));

        return redirect()->route('admin.products')->with('success', 'Produit ajouté avec succès.');
    }
}
