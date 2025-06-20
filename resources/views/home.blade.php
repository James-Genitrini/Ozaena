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

    <h1>Bienvenue sur Ozæna</h1>
    <p>Le site est en construction…</p>
@endsection