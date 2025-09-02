@extends('layouts.app')

@section('title', 'Validation du panier')

@push('styles')
    <style>
        .checkout-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            margin: 2rem auto;
            color: #ddd;
        }

        .column {
            flex: 1 1 350px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-width: 280px;
        }

        .checkout-box {
            background-color: #222;
            padding: 1rem;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .checkout-box h3 {
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            border-bottom: 1px solid #555;
            padding-bottom: 0.3rem;
        }

        .checkout-box input {
            width: 100%;
            padding: 0.7rem;
            border-radius: 6px;
            border: 1px solid #666;
            background-color: #2a2a2a;
            color: #fff;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: border 0.2s, background-color 0.2s;
        }

        .checkout-box input:focus {
            border-color: #0a84ff;
            background-color: #333;
            outline: none;
        }

        .btn-checkout {
            padding: 0.75rem;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            background-color: #0a84ff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 1rem;
        }

        .btn-checkout:hover {
            background-color: #0066cc;
        }

        .cart-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cart-summary li {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            border-bottom: 1px solid #444;
        }

        .cart-summary li:last-child {
            font-weight: bold;
            border-bottom: none;
        }

        .text-warning {
            color: #f0c000;
            margin-top: 1rem;
        }

        @media(max-width: 900px) {
            .checkout-container {
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="checkout-container">
            <!-- Colonne 1: Infos client -->
            <div class="column">
                <div class="checkout-box">
                    <h3>Informations client</h3>
                    <input type="text" name="first_name" placeholder="Prénom" required>
                    <input type="text" name="last_name" placeholder="Nom" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phone" placeholder="Téléphone">
                    <p style="font-size: 0.85rem; color: #aaa; margin-top: 0.5rem;">
                        L’adresse de livraison sera renseignée directement lors du paiement Stripe.
                    </p>
                </div>
            </div>

            <!-- Colonne 2: Récapitulatif -->
            <div class="column">
                <div class="checkout-box cart-summary">
                    <h3>Récapitulatif du panier</h3>
                    @php
                        $hasBundle = $cart->items->contains(fn($i) => $i->product->id === 1);
                        $shipping = $hasBundle ? 0 : 5;
                        $subtotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
                        $total = $subtotal + $shipping;
                    @endphp
                    <ul>
                        @foreach ($cart->items as $item)
                            <li>
                                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                <span>€{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                        <li>
                            <span>Livraison</span>
                            <span>€{{ number_format($shipping, 2) }}</span>
                        </li>
                        <li>
                            <span>Total</span>
                            <span>€{{ number_format($total, 2) }}</span>
                        </li>
                    </ul>
                    <p class="text-warning">
                        ⚠️ Tous les produits sont en <strong>précommande</strong>.
                    </p>
                    <button type="submit" class="btn-checkout">Procéder au paiement</button>
                </div>
            </div>
        </div>
    </form>
@endsection