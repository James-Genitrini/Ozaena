@extends('layouts.app')

@section('title', 'Accueil')

@push('styles')
    <style>
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 80vh;
            padding: 2rem 1rem;
            gap: 3rem;
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

        /* Bloc bundle + ses produits */
        .bundle-block {
            width: 100%;
            max-width: 1024px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .bundle-single {
            width: 100%;
            max-width: 600px;
        }

        .product-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            width: 100%;
        }

        .product-single {
            flex: 1 1 45%;
            max-width: 280px;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <h1 class="collection-title">Découvrez la collection Capsule 00</h1>

        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" class="logo-layer" />
        </div>

        {{-- Premier bundle et ses 2 produits --}}
        @if($products->count() >= 3)
            <div class="bundle-block">
                <div class="bundle-single">
                    <x-product-card :product="$products[0]" />
                </div>
                <div class="product-row">
                    @foreach($products->slice(2, 2) as $product)
                        <div class="product-single">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Deuxième bundle et ses 2 produits --}}
        @if($products->count() >= 6)
            <div class="bundle-block">
                <div class="bundle-single">
                    <x-product-card :product="$products[1]" />
                </div>
                <div class="product-row">
                    @foreach($products->slice(4, 2) as $product)
                        <div class="product-single">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection