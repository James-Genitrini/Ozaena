@extends('layouts.app')

@section('title', 'Produits')

@section('content')
    <div style="max-width: 900px; margin: 0 auto; padding: 2rem;">
        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; color: #F5F5F5; text-align: center;">Produits
        </h2>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; color: #F5F5F5;">
                <thead>
                    <tr style="border-bottom: 2px solid #333;">
                        <th style="text-align: left; padding: 0.75rem;">Nom</th>
                        <th style="text-align: left; padding: 0.75rem;">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr style="border-bottom: 1px solid #222;">
                            <td style="padding: 0.75rem;">{{ $product->name }}</td>
                            <td style="padding: 0.75rem;">{{ $product->price }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('admin.products.create') }}"
                style="background-color: #F5F5F5; color: #0D0D0D; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block;">
                Créer un produit
            </a>
        </div>
    </div>
@endsection