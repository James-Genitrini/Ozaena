@extends('layouts.app')

@section('title', 'Paiement réussi')

@section('content')
    <div class="max-w-3xl mx-auto mt-12 px-6 text-center">
        <h1 class="text-3xl font-bold mb-6 text-white">Merci pour votre commande !</h1>
        <p class="mb-4 text-gray-300">
            Votre paiement a été accepté et votre commande est en cours de traitement.
        </p>
        <p class="mb-4 text-gray-300 font-medium">
            Un e-mail de confirmation a été envoyé à l'adresse que vous avez fournie.
        </p>
        <a href="{{ route('home') }}" class="btn-checkout inline-block mt-4">Retour à l'accueil</a>
    </div>
@endsection

@push('styles')
    <style>
        .btn-checkout {
            color: #fff;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
    </style>
@endpush