@extends('layouts.app')

@section('title', 'Accueil')

@push('styles')
    <style>
        .logo-container {
            position: relative;
            width: 13rem;
            height: 13rem;
            margin: 1rem auto 1.5rem auto; /* réduit l'espace au-dessus et en-dessous */
            perspective: 1000px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Animation du logo */
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

        /* Slider */
        [x-data] {
            max-width: 1024px; /* limite la largeur */
            margin: 0 auto 3rem auto; /* plus d'espace entre slider et produits */
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            height: 20rem; /* hauteur par défaut, ajustable selon écran */
        }

        @media (min-width: 768px) {
            [x-data] {
                height: 24rem;
            }
        }

        @media (min-width: 1024px) {
            [x-data] {
                height: 32rem;
            }
        }

    </style>
@endpush

@section('content')
    <!-- Logo -->
    <div class="logo-container">
        <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" class="logo-layer" />
    </div>

    <div x-data="{
            activeSlide: 0,
            slides: [
                '{{ asset('images/slide1.png') }}',
                '{{ asset('images/slide2.png') }}'
            ],
            init() {
                this.interval = setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length
                }, 5000)
            },
            // Fonction pour stopper l'auto-slide si on survole
            stop() {
                clearInterval(this.interval)
            },
            start() {
                this.init()
            }
        }" @mouseenter="stop()" @mouseleave="start()"
        class="relative w-full max-w-4xl mx-auto overflow-hidden rounded-2xl shadow-lg h-64 md:h-96 lg:h-[32rem]">


        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0">

                <img :src="slide" alt="Slide" class="w-full h-full object-cover">
            </div>
        </template>

        <!-- Flèches -->
        <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
            class="absolute top-1/2 left-3 -translate-y-1/2 bg-white/70 hover:bg-white rounded-full p-2 shadow">
            ‹
        </button>
        <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
            class="absolute top-1/2 right-3 -translate-y-1/2 bg-white/70 hover:bg-white rounded-full p-2 shadow">
            ›
        </button>

        <!-- Points -->
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <div @click="activeSlide = index" class="w-3 h-3 rounded-full cursor-pointer"
                    :class="activeSlide === index ? 'bg-white' : 'bg-gray-400/70'">
                </div>
            </template>
        </div>
    </div>

    <!-- Grille de produits -->
    <div class="max-w-7xl mx-auto mt-16 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>

@endsection