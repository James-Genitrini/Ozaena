@extends('layouts.app')

@section('title', $product->name)

@push('styles')
    <style>
        .product-gallery {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .main-image {
            width: 100%;
            max-width: 400px;
            height: 400px;
            object-fit: contain;
            border: 1px solid #555;
            border-radius: 6px;
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
            background-color: #111;
            transition: all 0.3s;
        }

        .thumbnail.active,
        .thumbnail:hover {
            opacity: 1;
            border-color: #fff;
        }

        .size-btn {
            flex: 1;
            padding: 0.75rem 0;
            border: 1px solid #fff;
            border-radius: 6px;
            background: #fff;
            color: #000;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }

        .size-btn.disabled {
            opacity: 0.4;
            background: #444;
            color: #ccc;
            border-color: #444;
            cursor: not-allowed;
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

        .btn-add-cart {
            padding: 0.75rem 1.5rem;
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            transition: all 0.3s;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-add-cart:disabled {
            background-color: #666;
            color: #ccc;
            cursor: not-allowed;
        }

        .btn-add-cart:hover:not(:disabled) {
            background-color: #ddd;
        }

        .product-details {
            margin-top: 2rem;
            color: #bbb;
            max-width: 600px;
            text-align: justify;
        }

        .accordion-header {
            position: relative;
            padding-right: 2rem;
        }

        .accordion-header::after {
            content: '▼';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            transition: transform 0.3s;
        }

        .accordion-header.active::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .accordion-section {
            border: 1px solid #444;
            border-radius: 6px;
            background-color: #222;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-12">

        <!-- Galerie -->
        <div class="product-gallery md:col-span-2">
            <img id="mainImage" src="{{ asset($product->main_image_front) }}" alt="{{ $product->name }}"
                class="main-image mx-auto" />

            @php
                $galleryImages;
                if ($product->main_image_back) {
                    $galleryImages = collect([
                        (object) ['image_path' => $product->main_image_front],
                        (object) ['image_path' => $product->main_image_back],
                    ]);
                } else {
                    $galleryImages = collect([(object) ['image_path' => $product->main_image_front]]);
                }

                // Append $images à galleryImages
                if ($product->images && $product->images->count() > 0) {
                    foreach ($product->images as $img) {
                        $galleryImages->push($img);
                    }
                }
            @endphp

            <div class="thumbnails justify-center">
                @foreach($galleryImages as $img)
                    <img src="{{ asset($img->image_path) }}" alt="{{ $product->name }}"
                        class="thumbnail {{ $loop->first ? 'active' : '' }}"
                        onclick="document.getElementById('mainImage').src='{{ asset($img->image_path) }}'; setActiveThumbnail(this);" />
                @endforeach
            </div>

        </div>

        <!-- Détails -->
        <div class="text-white">
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-white text-justify mb-4">{{ $product->description }}</p>
            <p class="text-2xl font-semibold mb-6">€{{ number_format($product->price, 2) }}</p>

            <!-- Tailles -->
            <h3 class="font-semibold mb-2">Choisissez votre taille</h3>
            <div class="sizes flex gap-2 mb-4">
                @foreach($product->sizes as $size)
                    <button type="button" class="size-btn" data-size="{{ $size->size }}">
                        {{ $size->size }}
                    </button>
                @endforeach
            </div>


            <!-- Formulaire -->
            <form id="addToCartForm" action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                @csrf

                <!-- Quantité -->
                <div>
                    <label for="quantity" class="block text-sm mb-1">Quantité</label>
                    <input type="number" name="quantity" id="quantityInput" min="1" value="1"
                        class="w-24 px-2 py-1 rounded bg-[#111] border border-white text-white">
                </div>

                <input type="hidden" name="selected_size" id="selectedSizeInput">

                <button type="submit" id="addToCartBtn" class="btn-add-cart" disabled>Ajouter au panier</button>
            </form>

            <!-- Accordeon -->
            <div class="product-details mt-8 space-y-4">
                <div class="accordion-section">
                    <button type="button"
                        class="accordion-header w-full text-left px-4 py-3 font-semibold text-white hover:bg-[#333]">
                        Détails produit
                    </button>
                    <div class="accordion-content px-4 py-3 text-sm text-gray-300 hidden">
                        {{ $product->description }}
                        <br><br>
                        • Lavage à 30 °C <br>
                        • 100 % coton <br>
                        • 450 gsm (jogging et gilet) <br>
                        • Fabriqué au Pakistan
                    </div>
                </div>

                <div class="accordion-section">
                    <button type="button"
                        class="accordion-header w-full text-left px-4 py-3 font-semibold text-white hover:bg-[#333]">
                        Entretien
                    </button>
                    <div class="accordion-content px-4 py-3 text-sm text-gray-300 hidden">
                        Lavage en machine à 30 °C, ne pas blanchir, ne pas sécher en tambour, repassage à basse température.
                    </div>
                </div>

                {{-- Nouveau : Guide des tailles --}}
                <div class="accordion-section">
                    <button type="button"
                        class="accordion-header w-full text-left px-4 py-3 font-semibold text-white hover:bg-[#333]">
                        Guide des tailles
                    </button>
                    <div class="accordion-content px-4 py-3 text-sm text-gray-300 hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="pr-4">Taille</th>
                                    <th class="pr-4">Longueur (A)</th>
                                    <th class="pr-4">Poitrine (C)</th>
                                    <th class="pr-4">Épaules (B)</th>
                                    <th class="pr-4">Manches (G)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>S</td>
                                    <td>64,8 cm</td>
                                    <td>50,8 cm</td>
                                    <td>48,3 cm</td>
                                    <td>63,5 cm</td>
                                </tr>
                                <tr>
                                    <td>M</td>
                                    <td>67,3 cm</td>
                                    <td>54,6 cm</td>
                                    <td>50,8 cm</td>
                                    <td>64,8 cm</td>
                                </tr>
                                <tr>
                                    <td>L</td>
                                    <td>69,8 cm</td>
                                    <td>58,4 cm</td>
                                    <td>53,3 cm</td>
                                    <td>66,0 cm</td>
                                </tr>
                                <tr>
                                    <td>XL</td>
                                    <td>72,4 cm</td>
                                    <td>62,2 cm</td>
                                    <td>55,9 cm</td>
                                    <td>67,3 cm</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="mt-2">
                            Coupe oversize : si vous êtes entre deux tailles, prenez la plus petite pour un fit plus ajusté,
                            ou la plus grande pour un look encore plus loose.
                        </p>
                    </div>
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
                if (btn.classList.contains('disabled')) return;

                sizeButtons.forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
                selectedSize = btn.dataset.size;
                document.getElementById('selectedSizeInput').value = selectedSize;
                addToCartBtn.disabled = false;
            });
        });

        function setActiveThumbnail(el) {
            document.querySelectorAll('.thumbnail').forEach(img => img.classList.remove('active'));
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