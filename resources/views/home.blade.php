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

            <a href="{{ route('produit.show', ['id' => 1]) }}" class="group flex flex-col items-center cursor-pointer">
                <div class="w-64 h-64 relative overflow-hidden rounded-lg">
                    <img src="{{ asset('images/japon_front.png') }}" alt="Maillot Home"
                        class="w-full h-full object-contain transition-opacity duration-500 ease-in-out group-hover:opacity-0 absolute top-0 left-0" />
                    <img src="{{ asset('images/japon_back.png') }}" alt="Maillot Home Hover"
                        class="w-full h-full object-contain transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0" />
                </div>
                <h3 class="mt-4 text-lg font-semibold text-white-900">Maillot Home</h3>
                <p class="text-white-600 mt-1 text-base">€79.99</p>
            </a>

            <a href="{{ route('produit.show', ['id' => 2]) }}" class="group flex flex-col items-center cursor-pointer">
                <div class="w-64 h-64 relative overflow-hidden rounded-lg">
                    <img src="{{ asset('images/japon_front.png') }}" alt="Maillot Away"
                        class="w-full h-full object-contain transition-opacity duration-500 ease-in-out group-hover:opacity-0 absolute top-0 left-0" />
                    <img src="{{ asset('images/japon_back.png') }}" alt="Maillot Away Hover"
                        class="w-full h-full object-contain transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0" />
                </div>
                <h3 class="mt-4 text-lg font-semibold text-white-900">Maillot Away</h3>
                <p class="text-white-600 mt-1 text-base">€89.99</p>
            </a>

        </div>
    </div>


@endsection