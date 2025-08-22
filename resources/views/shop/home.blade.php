@extends('layouts.app')

@section('title', 'Accueil')

@push('styles')
    <style>
        /* Container principal */
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 80vh;
            padding: 2rem 1rem;
            gap: 3rem;
        }

        /* Logo centré */
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

        /* Bundle en haut */
        .product-bundle {
            width: 100%;
            max-width: 600px;
            /* plus gros sur desktop */
            margin-bottom: 2rem;
        }

        /* Container pour les deux autres produits */
        .product-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
            width: 100%;
            max-width: 1024px;
        }

        .product-single {
            flex: 1 1 45%;
            max-width: 280px;
        }

        @media(min-width: 768px) {
            .product-single {
                flex: 1 1 45%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" class="logo-layer" />
        </div>

        <!-- Gros bundle -->
        @if(isset($products[0]))
            <div class="product-bundle">
                <x-product-card :product="$products[0]" />
            </div>
        @endif

        <!-- Ligne des deux produits -->
        <div class="product-row">
            @if(isset($products[1]))
                <div class="product-single">
                    <x-product-card :product="$products[1]" />
                </div>
            @endif

            @if(isset($products[2]))
                <div class="product-single">
                    <x-product-card :product="$products[2]" />
                </div>
            @endif
        </div>
    </div>
@endsection