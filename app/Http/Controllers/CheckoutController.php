<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
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
        $cart = Auth::user()?->cart()->with('items.product')->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->setRelation('items', collect());
        }

        // Utiliser la session pour le front
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
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'country' => 'required|in:FR',
        ]);

        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

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

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $validated['email'],
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.show'),
        ]);

        // Stocker temporairement toutes les infos client
        session(['checkout_data' => $validated]);

        // Redirection vers Stripe
        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        $data = session('checkout_data', []);

        // Créer la commande uniquement après paiement
        $orderTotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'address' => $data['address'] ?? '',
            'postal_code' => $data['postal_code'] ?? '',
            'city' => $data['city'] ?? '',
            'country' => $data['country'] ?? 'FR',
            'status' => 'paid',
            'total' => $orderTotal,
            'delivery_note' => 'Précommande - délai dépendant du fournisseur',
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product->id,
                'size' => $item->size ?? null,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
            ]);
        }

        // Nettoyage
        if (Auth::user()?->cart) {
            Auth::user()->cart->items()->delete();
        }
        session()->forget('cart');
        session()->forget('checkout_data');

        return view('checkout.success', compact('order'));
    }
}