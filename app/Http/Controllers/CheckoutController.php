<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Récupère le panier de l'utilisateur ou de la session
     */
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

    /**
     * Affiche la page de checkout
     */
    public function show()
    {
        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        return view('checkout.show', compact('cart'));
    }

    /**
     * Traitement du checkout et création de la session Stripe
     */
    public function process(Request $request)
    {
        // Validation des informations de livraison
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'country' => 'required|in:FR',
            'email' => 'required_if:auth,0|email',
        ]);

        $cart = $this->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide.');
        }

        // Calcul des lignes pour Stripe
        $lineItems = [];
        foreach ($cart->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->product->name . ($item->size ? " (Taille: {$item->size})" : ''),
                    ],
                    'unit_amount' => intval($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        // Création de la commande avant Stripe
        $orderTotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'address' => $validated['address'],
            'postal_code' => $validated['postal_code'],
            'city' => $validated['city'],
            'country' => $validated['country'],
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

        // Stocker temporairement l'ID de la commande pour le succès Stripe
        session(['checkout_order_id' => $order->id]);

        // Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => Auth::check() ? Auth::user()->email : $validated['email'],
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.show'),
        ]);

        return redirect($session->url);
    }

    /**
     * Page de succès Stripe
     */
    public function success()
    {
        $orderId = session('checkout_order_id');

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['status' => 'paid']);
            }

            // Vider le panier
            if (Auth::check() && Auth::user()->cart) {
                Auth::user()->cart->items()->delete();
            } else {
                session()->forget('cart');
            }

            session()->forget('checkout_order_id');
        }

        return view('checkout.success');
    }
}