<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart()->with('items.product')->first();

            if (!$cart) {
                $cart = new Cart();
                $cart->setRelation('items', collect());
            }
        } else {
            $cart = new Cart();
            $cart->setRelation('items', collect());
        }

        // Toujours récupérer le panier en session pour le front-end
        $sessionItems = collect(session('cart', []))->map(function ($item) {
            $item['product'] = Product::find($item['product_id']);
            return (object) $item;
        });

        $cart->setRelation('items', $sessionItems);

        return view('cart.show', compact('cart'));
    }

    public function addProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'selected_size' => 'required|string|max:10',
        ]);

        // Mise à jour DB si connecté
        if (Auth::check()) {
            $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);

            $item = $cart->items()
                ->where('product_id', $product->id)
                ->where('size', $validated['selected_size'])
                ->first();

            if ($item) {
                $item->increment('quantity', $validated['quantity']);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'size' => $validated['selected_size'],
                    'quantity' => $validated['quantity'],
                ]);
            }
        }

        // Mise à jour session
        $cartSession = session('cart', []);
        $index = collect($cartSession)->search(fn($i) => $i['product_id'] === $product->id && $i['size'] === $validated['selected_size']);

        if ($index !== false) {
            $cartSession[$index]['quantity'] += $validated['quantity'];
        } else {
            $cartSession[] = [
                'product_id' => $product->id,
                'size' => $validated['selected_size'],
                'quantity' => $validated['quantity'],
            ];
        }

        session(['cart' => $cartSession]);

        return redirect()->back()->with('success', 'Produit ajouté au panier.');
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'selected_size' => 'required|string|max:10',
        ]);

        // Mise à jour DB si connecté
        if (Auth::check()) {
            $cart = Auth::user()->cart;
            $item = $cart->items()
                ->where('product_id', $product->id)
                ->where('size', $validated['selected_size'])
                ->first();

            if ($item) {
                $item->update(['quantity' => $validated['quantity']]);
            }
        }

        // Mise à jour session
        $cartItems = collect(session('cart', []))->map(function ($item) use ($product, $validated) {
            if ($item['product_id'] === $product->id && $item['size'] === $validated['selected_size']) {
                $item['quantity'] = $validated['quantity'];
            }
            return $item;
        });

        session(['cart' => $cartItems->toArray()]);

        $total = $cartItems->sum(fn($item) => Product::find($item['product_id'])->price * $item['quantity']);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'cart_total' => $total]);
        }

        return redirect()->back()->with('success', 'Quantité mise à jour.');
    }

    public function removeProduct(Request $request, Product $product)
    {
        $validated = $request->validate(['selected_size' => 'required|string|max:10']);

        // Mise à jour DB si connecté
        if (Auth::check()) {
            $cart = Auth::user()->cart;
            $item = $cart->items()
                ->where('product_id', $product->id)
                ->where('size', $validated['selected_size'])
                ->first();

            if ($item) {
                $item->delete();
            }
        }

        // Mise à jour session
        $cart = collect(session('cart', []))->reject(
            fn($item) => $item['product_id'] === $product->id && $item['size'] === $validated['selected_size']
        );

        session(['cart' => $cart->values()->toArray()]);

        return redirect()->back()->with('success', 'Produit supprimé du panier.');
    }

    public static function getCartCount()
    {
        $cart = session('cart', []);
        return collect($cart)->sum(fn($item) => $item['quantity'] ?? 1);
    }
}