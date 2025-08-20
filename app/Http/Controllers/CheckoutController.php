<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CheckoutController extends Controller
{
    protected function getCart()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart()->with('items.product')->first();

            if (!$cart) {
                $cart = new Cart();
                $cart->setRelation('items', collect());
            }
        } else {
            $sessionItems = collect(session('cart', []))->map(function ($item) {
                $item['product'] = Product::find($item['product_id']);
                return (object) $item;
            });
            $cart = new Cart();
            $cart->setRelation('items', $sessionItems);
        }

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
        $request->validate([
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
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => intval($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => Auth::check() ? Auth::user()->email : $request->input('email'),
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.show'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        if (Auth::check() && Auth::user()->cart) {
            Auth::user()->cart->items()->delete();
        } else {
            session()->forget('cart');
        }

        return view('checkout.success');
    }
}