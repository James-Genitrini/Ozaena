@extends('layouts.app')

@section('title', 'Collection 000')

@push('styles')
    <style>
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 80vh;
            padding: 2rem 1rem;
            gap: 3rem;
            position: relative;
            /* nécessaire si on garde une position absolue dans ce bloc */
        }

        .collection-title {
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-top: 1rem;
        }

        .logo-container {
            width: 13rem;
            height: 13rem;
            perspective: 1000px;
            display: flex;
            justify-content: center;
            align-items: center;
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

        .product-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            width: 100%;
            max-width: 1024px;
        }

        .product-single {
            flex: 1 1 45%;
            max-width: 280px;
        }

        /* --- Bandelette livraison --- */
        .shipping-banner {
            position: absolute;
            top: 4rem;
            /* descend sous la navbar */
            right: -4rem;
            color: rgba(255, 255, 0, 0.753);
            padding: 0.5rem 4rem;
            font-size: 0.9rem;
            font-weight: 600;
            transform: rotate(45deg);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 5;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <!-- Bandelette en haut à droite mais plus bas -->
        <div class="shipping-banner">
            Livraison offerte dès 100€
        </div>

        <h1 class="collection-title">Découvrez la collection Capsule 00</h1>

        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" class="logo-layer" />
        </div>

        {{-- Première ligne : 2 produits --}}
        @if($products->count() >= 2)
            <div class="product-row">
                @foreach($products->take(2) as $product)
                    <div class="product-single">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Deuxième ligne : 2 autres produits --}}
        @if($products->count() >= 4)
            <div class="product-row">
                @foreach($products->slice(2, 2) as $product)
                    <div class="product-single">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection