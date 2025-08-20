@extends('layouts.app')

@section('title', 'Validation du panier')

@push('styles')
    <style>
        body {
            background-color: #111;
            color: #ddd;
        }

        .checkout-container {
            max-width: 700px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: #1a1a1a;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .checkout-container h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .checkout-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .checkout-form input,
        .checkout-form select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 6px;
            border: 1px solid #555;
            background-color: #222;
            color: #fff;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            background-color: #0a84ff;
            color: #fff;
            padding: 0.75rem;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #0066cc;
        }

        .cart-summary {
            background-color: #222;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .cart-summary ul {
            list-style: none;
            padding: 0;
        }

        .cart-summary li {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #444;
        }

        .cart-summary li:last-child {
            border-bottom: none;
            font-weight: bold;
        }

        .errors {
            margin-top: 1rem;
            color: #ff4d4f;
        }
    </style>
@endpush

@section('content')
    <div class="checkout-container">
        <h1>Validation de votre panier</h1>

        <div class="cart-summary">
            <h2 class="mb-2">Récapitulatif</h2>
            <ul>
                @foreach ($cart->items as $item)
                    <li>
                        <span>{{ $item->product->name }} ({{ $item->size }}) x {{ $item->quantity }}</span>
                        <span>€{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </li>
                @endforeach
                <li>
                    <span>Total</span>
                    <span>€{{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 2) }}</span>
                </li>
            </ul>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" class="checkout-form">
            @csrf

            <label for="address">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}" required>

            <label for="postal_code">Code postal</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required>

            <label for="city">Ville</label>
            <input type="text" name="city" id="city" value="{{ old('city') }}" required>

            <label for="country">Pays</label>
            <select name="country" id="country" required>
                <option value="FR" selected>France</option>
            </select>

            <button type="submit" class="btn-checkout">Payer avec Stripe</button>
        </form>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection