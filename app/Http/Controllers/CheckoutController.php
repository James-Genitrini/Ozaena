<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Str;
use Stripe\Checkout\Session;
use Stripe\Customer;
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
        ]);

        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        $hasBundle = $cart->items->contains(fn($i) => $i->product->id === 1);
        $shippingFee = $hasBundle ? 0 : 5;

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

        if ($shippingFee > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Frais de livraison',
                    ],
                    'unit_amount' => $shippingFee * 100,
                ],
                'quantity' => 1,
            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $validated['email'],
            'shipping_address_collection' => [
                'allowed_countries' => ['FR'],
            ],
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.show'),
            'metadata' => [
                'user_id' => (string) Auth::id(),
                'has_bundle' => $hasBundle ? 'yes' : 'no',
            ],
        ]);


        // Redirection vers Stripe
        return redirect()->away($session->url);
    }


    public function success(Request $request)
    {
        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');
        $stripeSession = Session::retrieve([
            'id' => $sessionId,
            'expand' => ['shipping'],
        ]);

        // Récupération de l'adresse de livraison depuis Stripe
        $shipping = $stripeSession->customer_details ?? null;

        if ($shipping) {
            $fullName = $shipping->name ?? '';
            $address = $shipping->address ?? null;
            $phone = $shipping->phone ?? '';
        } else {
            // Fallback si Stripe ne renvoie pas d'adresse
            $fullName = $request->input('first_name') . ' ' . $request->input('last_name');
            $address = (object) [
                'line1' => $request->input('address') ?? '',
                'city' => $request->input('city') ?? '',
                'postal_code' => $request->input('postal_code') ?? '',
                'country' => $request->input('country') ?? 'FR',
            ];
            $phone = $request->input('phone') ?? '';
        }

        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0] ?? '';
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

        // Calcul du total
        $orderTotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
        if (!$cart->items->contains(fn($i) => $i->product->id === 1)) {
            $orderTotal += 5; // frais de livraison
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'uuid' => (string) Str::uuid(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $stripeSession->customer_email,
            'phone' => $phone,
            'address' => $address->line1 ?? '',
            'postal_code' => $address->postal_code ?? '',
            'city' => $address->city ?? '',
            'country' => $address->country ?? 'FR',
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

        // Envoi du mail de confirmation
        Mail::to($order->email)->send(new OrderConfirmationMail($order));

        // Nettoyage du panier
        if (Auth::user()?->cart) {
            Auth::user()->cart->items()->delete();
        }
        session()->forget('cart');

        return view('checkout.success', compact('order'));
    }

}