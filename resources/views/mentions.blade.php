@extends('layouts.app')

@section('title', 'Mentions légales')

@push('styles')
    <style>
        .legal-container {
            max-width: 680px;
            margin: 2rem auto;
            padding: 1rem 1.5rem;
            color: #ddd;
            text-align: justify;
            line-height: 1.6;
            font-size: 1.05rem;
        }

        .legal-container h1 {
            font-weight: 700;
            font-size: 2.25rem;
            margin-bottom: 1.5rem;
            color: #eee;
            text-align: left;
        }

        .legal-container p {
            margin-bottom: 1.2rem;
        }

        .legal-container strong {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: 600;
        }

        .legal-container a {
            color: #4ea1d3;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .legal-container a:hover {
            color: #7ec1f7;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <div class="legal-container">
        <h1>Mentions légales</h1>

        <p><strong>Éditeur du site :</strong>
            Ozæna SARL<br>
            SIRET : 990 958 506 00018<br>
            Adresse : 519 A LES COREAUX, 68910 LABAROCHE<br>
            Email : <a href="mailto:contact@ozæna.com">contact@ozæna.com</a><br>
            Téléphone : +33 1 23 45 67 89
        </p>

        <p><strong>Directeur de la publication :</strong>
            Damien PIMMEL
        </p>

        <p><strong>Hébergeur :</strong>
            OVH SAS<br>
            2 rue Kellermann - 59100 Roubaix - France<br>
            Téléphone : 1007
        </p>

        <p>
            Ce site est la propriété de Ozæna SARL. Toute reproduction partielle ou totale est interdite sans autorisation
            préalable.
        </p>
    </div>
@endsection