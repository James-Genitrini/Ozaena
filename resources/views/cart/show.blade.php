@extends('layouts.app')

@section('title', 'Mon panier')

@push('styles')
    <style>
        .logo-container {
            position: relative;
            width: 13rem;
            height: 13rem;
            margin: 0 auto 2rem auto;
            perspective: 1000px;
            display: flex;
            justify-content: center;
            align-items: center;
            transform: translateY(-2rem);
        }

        .logo-layer {
            width: 60%;
            height: 60%;
            animation: spin 7s linear infinite;
            transform-style: preserve-3d;
        }

        @keyframes spin {
            from {
                transform: rotateY(0deg);
            }

            to {
                transform: rotateY(360deg);
            }
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            color: #ddd;
        }

        .cart-table th,
        .cart-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #444;
            text-align: left;
        }

        .cart-table th {
            border-bottom: 2px solid #666;
        }

        .btn-update,
        .btn-remove {
            background-color: #222;
            color: #fff;
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-update:hover {
            background-color: #444;
        }

        .btn-remove {
            background-color: #a00;
        }

        .btn-remove:hover {
            background-color: #d33;
        }

        input[type="number"] {
            width: 60px;
            padding: 0.3rem 0.5rem;
            border-radius: 4px;
            border: 1px solid #666;
            background-color: #111;
            color: #ddd;
            text-align: center;
        }

        .empty-cart {
            text-align: center;
            padding: 4rem 0;
            font-size: 1.25rem;
            color: #bbb;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto mt-12 px-6">
        @if ($cart && $cart->items->count() > 0)
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Taille</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->items as $item)
                        <tr>
                            <td>
                                <a href="{{ route('produit.show', $item->product->slug) }}"
                                    class="font-semibold hover:underline text-white">
                                    {{ $item->product->name }}
                                </a>
                            </td>
                            <td>{{ $item->size }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', [$item->product]) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="selected_size" value="{{ $item->size }}">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" />
                                    <button type="submit" class="btn-update" title="Mettre à jour la quantité">Modifier</button>
                                </form>
                            </td>
                            <td>€{{ number_format($item->product->price, 2) }}</td>
                            <td>€{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', [$item->product]) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="selected_size" value="{{ $item->size }}">
                                    <button type="submit" class="btn-remove" title="Supprimer du panier">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-bold">Total général :</td>
                        <td colspan="2" class="font-semibold">
                            €{{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        @else
            <p class="empty-cart">Votre panier est vide.</p>
        @endif
    </div>
@endsection