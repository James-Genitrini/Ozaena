@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 1.5rem; text-align: center;">
            Dashboard Admin
        </h1>

        <div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center; margin-bottom: 2rem;">
            <!-- Total commandes -->
            <div
                style="background-color: #1a1a1a; padding: 1.5rem; border-radius: 12px; flex: 1 1 200px; min-width: 200px; text-align: center;">
                <h2 style="font-size: 1.5rem; font-weight: 600;">{{ $ordersCount }}</h2>
                <p>Total commandes</p>
            </div>

            <!-- Total produits -->
            <div
                style="background-color: #1a1a1a; padding: 1.5rem; border-radius: 12px; flex: 1 1 200px; min-width: 200px; text-align: center;">
                <h2 style="font-size: 1.5rem; font-weight: 600;">{{ $productsCount }}</h2>
                <p>Total produits</p>
            </div>
        </div>

        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.orders') }}"
                style="background-color: #F5F5F5; color: #0D0D0D; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.3s;">
                Voir les commandes
            </a>
            <a href="{{ route('admin.products') }}"
                style="background-color: #F5F5F5; color: #0D0D0D; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.3s;">
                Voir les produits
            </a>
        </div>
    </div>
@endsection