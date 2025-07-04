@extends('layouts.app')

@section('title', 'Accueil')

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
        </style>
@endpush

@section('content')
    <div class="logo-container">
        <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" class="logo-layer" />
    </div>

    <div class="max-w-7xl mx-auto mt-12 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
@endsection