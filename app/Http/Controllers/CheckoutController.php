<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Customer as StripeCustomer;
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

        $priceTotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
        $shippingFree = $priceTotal >= 100 ? 0 : 5;

        // Création de la commande en pending
        $order = Order::create([
            'user_id' => Auth::id(),
            'uuid' => (string) Str::uuid(),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? '',
            'status' => 'pending',
            'total' => $priceTotal + $shippingFree,
            'address' => '', // placeholder vide
            'postal_code' => '',
            'city' => '',
            'country' => 'FR',
        ]);

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

        if ($shippingFree > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => ['name' => 'Frais de livraison'],
                    'unit_amount' => $shippingFree * 100,
                ],
                'quantity' => 1,
            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Création du Customer Stripe avec description contenant UUID
        $customer = StripeCustomer::create([
            'email' => $validated['email'],
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'phone' => $validated['phone'] ?? null,
            'description' => 'Commande UUID: ' . $order->uuid,
        ]);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer' => $customer->id, // ✅ pas de customer_email ici
            'shipping_address_collection' => [
                'allowed_countries' => ['FR'],
            ],
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.show'),
            'client_reference_id' => $order->uuid,
            'metadata' => [
                'user_id' => (string) Auth::id(),
                'order_uuid' => $order->uuid,
            ],
        ]);

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
            'expand' => ['shipping', 'customer'],
        ]);

        $orderUuid = $stripeSession->metadata->order_uuid ?? null;
        $order = Order::where('uuid', $orderUuid)->firstOrFail();

        $shipping = $stripeSession->customer_details ?? null;
        $customer = $stripeSession->customer ?? null;

        if ($shipping) {
            $fullName = $shipping->name ?? ($customer->name ?? '');
            $address = $shipping->address ?? null;
            $phone = $shipping->phone ?? ($customer->phone ?? '');
            $email = $customer->email ?? $stripeSession->customer_email ?? $order->email;
        } else {
            $fullName = $order->first_name . ' ' . $order->last_name;
            $address = (object) [
                'line1' => '',
                'city' => '',
                'postal_code' => '',
                'country' => 'FR',
            ];
            $phone = $order->phone ?? '';
            $email = $order->email;
        }

        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0] ?? '';
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

        $order->update([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address->line1 ?? '',
            'postal_code' => $address->postal_code ?? '',
            'city' => $address->city ?? '',
            'country' => $address->country ?? 'FR',
            'status' => 'paid',
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

        Mail::to($order->email)->send(new OrderConfirmationMail($order));

        if (Auth::user()?->cart) {
            Auth::user()->cart->items()->delete();
        }
        session()->forget('cart');

        return view('checkout.success', compact('order'));
    }
}