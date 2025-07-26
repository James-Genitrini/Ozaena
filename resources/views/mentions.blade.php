@extends('layouts.app')

@section('title', 'Mentions légales')

@section('content')
    <div class="max-w-4xl mx-auto text-left px-4 py-8" style="color: #ddd;">
        <h1 class="text-3xl font-bold mb-6">Mentions légales</h1>

        <p><strong>Éditeur du site :</strong><br>
            Ozæna SARL<br>
            SIRET : 123 456 789 00012<br>
            Adresse : 123 Rue Exemple, 75000 Paris<br>
            Email : <a href="mailto:contact@ozæna.com" style="color: #4ea1d3;">contact@ozæna.com</a><br>
            Téléphone : +33 1 23 45 67 89
        </p>

        <p><strong>Directeur de la publication :</strong><br>
            Jean Dupont
        </p>

        <p><strong>Hébergeur :</strong><br>
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