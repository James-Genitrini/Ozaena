<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

class CheckoutController extends Controller
{
    protected function getCart()
    {
        $cart = Auth::user()->cart()->with('items.product')->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->setRelation('items', collect());
        }

        // Toujours utiliser la session pour le front-end
        $sessionItems = collect(session('cart', []))->map(function ($item) {
            $item['product'] = Product::find($item['product_id']);
            return (object) $item;
        });

        $cart->setRelation('items', $sessionItems);

        return $cart;
    }

    public function show()
    {
        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        return view('checkout.show', compact('cart'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'country' => 'required|in:FR',
        ]);

        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        // Préparer les lignes Stripe
        $lineItems = [];
        foreach ($cart->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->product->name . ($item->size ? " (Taille: {$item->size})" : ''),
                    ],
                    'unit_amount' => round($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => Auth::user()->email,
            'success_url' => route('checkout.success'), // la commande sera créée ici
            'cancel_url' => route('checkout.show'),
        ]);

        // Stocker temporairement l'adresse pour la commande
        session(['checkout_address' => $validated]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        $address = session('checkout_address', []);

        // Créer la commande uniquement après paiement réussi
        $orderTotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'paid',
            'address' => $address['address'] ?? '',
            'postal_code' => $address['postal_code'] ?? '',
            'city' => $address['city'] ?? '',
            'country' => $address['country'] ?? '',
            'total' => $orderTotal,
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product->id,
                'size' => $item->size ?? null,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
            ]);
        }

        // Vider le panier
        if (Auth::user()->cart) {
            Auth::user()->cart->items()->delete();
        }
        session()->forget('cart');
        session()->forget('checkout_address');

        return view('checkout.success', compact('order'));
    }
}