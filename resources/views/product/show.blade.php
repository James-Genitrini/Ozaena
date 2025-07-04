@extends('layouts.app')

@section('title', $product->name)

@push('styles')
    <style>
        /* Basique pour la galerie */
        .product-gallery {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .main-image {
            width: 400px;
            height: 400px;
            object-fit: contain;
            border: 1px solid #555;
            border-radius: 4px;
            cursor: pointer;
            background-color: #111;
        }
        .thumbnails {
            display: flex;
            gap: 0.5rem;
        }
        .thumbnail {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border: 1px solid #555;
            border-radius: 4px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s, border-color 0.3s;
            background-color: #111;
        }
        .thumbnail.active,
        .thumbnail:hover {
            opacity: 1;
            border-color: #fff;
        }

        /* Tailles boutons uniformes */
        .sizes {
            display: flex;
            gap: 0.5rem;
            margin: 1rem 0;
        }
        .size-btn {
            flex: 1; /* même largeur */
            padding: 0.75rem 0;
            border: 1px solid #fff;
            border-radius: 6px;
            cursor: pointer;
            background: #fff; /* fond blanc */
            color: #000;      /* texte noir */
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            user-select: none;
        }
        .size-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #444;
            color: #ccc;
            border-color: #444;
            text-decoration: line-through;
        }

        .size-btn.selected {
            background-color: #222;
            color: #fff;
            border-color: #fff;
        }
        .size-btn:hover:not(.disabled):not(.selected) {
            background-color: #eee;
        }

        /* Bouton Ajouter au panier */
        .btn-add-cart {
            padding: 0.75rem 1.5rem;
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 1rem;
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
        }
        .btn-add-cart:disabled {
            background-color: #666;
            color: #ccc;
            cursor: not-allowed;
        }
        .btn-add-cart:hover:not(:disabled) {
            background-color: #ddd;
        }

        /* Texte gris clair pour descriptions */
        .product-details {
            margin-top: 2rem;
            max-width: 600px;
            color: #bbb;
        }

        .details-section {
            margin-bottom: 2rem;
        }
        .details-section h4 {
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #fff;
        }
        .details-section p {
            color: #bbb;
            line-height: 1.5;
        }
        .accordion-content {
            transition: all 0.3s ease;
        }
        .accordion-header {
            position: relative;
            padding-right: 2rem; /* espace pour la flèche */
        }

        .accordion-header::after {
            content: '▼'; /* flèche bas */
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            transition: transform 0.3s ease;
        }

        .accordion-header.active::after {
            transform: translateY(-50%) rotate(180deg); /* flèche haut */
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-x-2 gap-y-12">

        <div class="product-gallery md:col-span-2">
            <img id="mainImage" src="{{ asset($product->main_image_front) }}" alt="{{ $product->name }}" class="main-image" />

            <div class="thumbnails">
                @foreach($images as $img)
                    <img 
                        src="{{ asset($img->image_path) }}" 
                        alt="{{ $product->name }} image" 
                        class="thumbnail {{ $loop->first ? 'active' : '' }}"
                        onclick="document.getElementById('mainImage').src='{{ asset($img->image_path) }}'; setActiveThumbnail(this);"
                    />
                @endforeach
            </div>
        </div>

    <!-- Infos produit -->
    <div>
        <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
        <p class="mb-6 text-white-700">{{ $product->description }}</p>
        <p class="text-2xl font-semibold mb-6">€{{ number_format($product->price, 2) }}</p>

        <h3 class="font-semibold mb-2">Choisissez votre taille</h3>
        <div class="sizes">
            @foreach($stocks as $stock)
                <button 
                    type="button" 
                    class="size-btn {{ $stock->quantity <= 0 ? 'disabled' : '' }}"
                    data-size="{{ $stock->size }}"
                    data-quantity="{{ $stock->quantity }}"
                    @if($stock->quantity <= 0) disabled @endif
                >
                    {{ $stock->size }}
                </button>
            @endforeach
        </div>

        <button id="addToCartBtn" class="btn-add-cart" disabled>Ajouter au panier</button>

        <div class="product-details mt-6 space-y-4">
            <div class="accordion-section border border-gray-600 rounded">
                <button type="button"
                    class="accordion-header w-full text-left px-4 py-3 font-semibold text-white bg-[#222] hover:bg-[#333]">
                    Détails produit
                </button>
                <div class="accordion-content px-4 py-3 text-sm text-gray-300 hidden">
                    Maillot domicile du Japon, coupe ajustée et matériaux respirants pour un confort optimal.
                </div>
            </div>

            <div class="accordion-section border border-gray-600 rounded">
                <button type="button"
                    class="accordion-header w-full text-left px-4 py-3 font-semibold text-white bg-[#222] hover:bg-[#333]">
                    Entretien
                </button>
                <div class="accordion-content px-4 py-3 text-sm text-gray-300 hidden">
                    Lavage en machine à 30°C, ne pas blanchir, ne pas sécher en tambour, repassage à basse température.
                </div>
            </div>
        </div>

    </div>

    <script>
        const sizeButtons = document.querySelectorAll('.size-btn');
        const addToCartBtn = document.getElementById('addToCartBtn');
        let selectedSize = null;

        sizeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                if(btn.classList.contains('disabled')) return;

                sizeButtons.forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
                selectedSize = btn.dataset.size;

                addToCartBtn.disabled = false;
            });
        });

        addToCartBtn.addEventListener('click', () => {
            if(!selectedSize) return alert('Veuillez sélectionner une taille');

            alert('Produit ajouté au panier: Taille ' + selectedSize);
        });

        // Gestion active thumbnail (changer bordure)
        function setActiveThumbnail(el) {
            document.querySelectorAll('.thumbnail').forEach(img => {
                img.classList.remove('active');
            });
            el.classList.add('active');
        }

        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                content.classList.toggle('hidden');
                header.classList.toggle('active');
            });
        });
    </script>
@endsection
