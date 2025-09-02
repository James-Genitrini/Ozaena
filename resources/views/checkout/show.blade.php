@extends('layouts.app')

@section('title', 'Validation du panier')

@push('styles')
    <style>
        .checkout-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            margin: 2rem auto;
            color: #ddd;
        }

        .column {
            flex: 1 1 350px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-width: 280px;
        }

        .checkout-box {
            background-color: #222;
            padding: 1rem;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .checkout-box h3 {
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            border-bottom: 1px solid #555;
            padding-bottom: 0.3rem;
        }

        .checkout-box input,
        .checkout-box select {
            width: 100%;
            padding: 0.7rem;
            border-radius: 6px;
            border: 1px solid #666;
            background-color: #2a2a2a;
            color: #fff;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: border 0.2s, background-color 0.2s;
        }

        .checkout-box input:focus,
        .checkout-box select:focus {
            border-color: #0a84ff;
            background-color: #333;
            outline: none;
        }

        .btn-checkout {
            padding: 0.75rem;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            background-color: #0a84ff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 1rem;
        }

        .btn-checkout:hover {
            background-color: #0066cc;
        }

        .cart-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cart-summary li {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            border-bottom: 1px solid #444;
        }

        .cart-summary li:last-child {
            font-weight: bold;
            border-bottom: none;
        }

        .text-warning {
            color: #f0c000;
            margin-top: 1rem;
        }

        @media(max-width: 900px) {
            .checkout-container {
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="checkout-container">
            <!-- Colonne 1: Infos personnelles -->
            <div class="column">
                <div class="checkout-box">
                    <h3>Informations personnelles</h3>
                    <input type="text" name="first_name" placeholder="Prénom" required>
                    <input type="text" name="last_name" placeholder="Nom" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phone" placeholder="Téléphone">
                </div>
            </div>

            <!-- Colonne 2: Livraison -->
            <div class="column">
                <div class="checkout-box" style="position: relative;">
                    <h3>Adresse de livraison</h3>
                    <div class="autocomplete">
                        <input type="text" name="address" id="address" placeholder="Adresse" required>
                        <div id="address-suggestions" class="suggestions"></div>
                    </div>

                    <!-- Champ complément d'adresse -->
                    <input type="text" name="address_apt" id="address_apt"
                        placeholder="Appartement, étage, suite (facultatif)">
                    <input type="text" name="postal_code" id="postal_code" placeholder="Code postal" required>
                    <input type="text" name="city" id="city" placeholder="Ville" required>
                    <select name="country" id="country" required>
                        <option value="FR" selected>France</option>
                    </select>
                </div>
            </div>

            <!-- Colonne 3: Récap + paiement -->
            <div class="column">
                <div class="checkout-box cart-summary">
                    <h3>Récapitulatif du panier</h3>

                    @php
                        // Vérifie si le panier contient un bundle
                        $hasBundle = $cart->items->contains(fn($i) => $i->product->id === 1);
                        $shipping = $hasBundle ? 0 : 5;
                        $subtotal = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
                        $total = $subtotal + $shipping;
                    @endphp

                    <ul>
                        @foreach ($cart->items as $item)
                            <li>
                                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                <span>€{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                        <li>
                            <span>Livraison</span>
                            <span>€{{ number_format($shipping, 2) }}</span>
                        </li>
                        <li>
                            <span>Total</span>
                            <span>€{{ number_format($total, 2) }}</span>
                        </li>
                    </ul>

                    <p class="text-warning">
                        ⚠️ Tous les produits sont en <strong>précommande</strong>.
                    </p>
                    <button type="submit" class="btn-checkout">Procéder au paiement</button>
                </div>
            </div>
        </div>
    </form>

    {{-- JS Autocomplete adresse --}}
    <script>
        (() => {
            const addressInput = document.getElementById('address');
            const suggestionsBox = document.getElementById('address-suggestions');
            const postal = document.getElementById('postal_code');
            const city = document.getElementById('city');

            let activeIndex = -1;
            let items = [];
            let controller = null;
            let debounceTimer = null;

            function clearSuggestions() {
                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
                items = [];
                activeIndex = -1;
            }

            function renderSuggestions(features) {
                suggestionsBox.innerHTML = '';
                items = features.map((f, idx) => {
                    const div = document.createElement('div');
                    div.className = 'suggestion-item';
                    div.textContent = f.properties.label;
                    div.addEventListener('mousedown', e => { e.preventDefault(); chooseFeature(f); });
                    suggestionsBox.appendChild(div);
                    return { el: div, feature: f };
                });
                suggestionsBox.style.display = items.length ? 'block' : 'none';
            }

            function chooseFeature(f) {
                addressInput.value = f.properties.street || '';
                if (postal) postal.value = f.properties.postcode || '';
                if (city) city.value = f.properties.city || '';
                clearSuggestions();
            }

            function setActive(index) {
                if (!items.length) return;
                items.forEach((it, i) => it.el.setAttribute('aria-selected', i === index ? 'true' : 'false'));
                activeIndex = index;
                const activeEl = items[index]?.el;
                if (activeEl) {
                    const rect = activeEl.getBoundingClientRect();
                    const parentRect = suggestionsBox.getBoundingClientRect();
                    if (rect.bottom > parentRect.bottom) activeEl.scrollIntoView(false);
                    if (rect.top < parentRect.top) activeEl.scrollIntoView();
                }
            }

            async function fetchAddresses(q) {
                if (controller) controller.abort();
                controller = new AbortController();
                try {
                    const res = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(q)}&limit=5`, { signal: controller.signal });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();
                    renderSuggestions(data.features || []);
                } catch (e) { if (e.name !== 'AbortError') clearSuggestions(); }
            }

            addressInput.addEventListener('input', () => {
                const q = addressInput.value.trim();
                clearTimeout(debounceTimer);
                if (q.length < 3) { clearSuggestions(); return; }
                debounceTimer = setTimeout(() => fetchAddresses(q), 220);
            });

            addressInput.addEventListener('keydown', e => {
                if (suggestionsBox.style.display !== 'block') return;
                if (e.key === 'ArrowDown') { e.preventDefault(); setActive(activeIndex < items.length - 1 ? activeIndex + 1 : 0); }
                else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(activeIndex > 0 ? activeIndex - 1 : items.length - 1); }
                else if (e.key === 'Enter') { if (activeIndex >= 0 && items[activeIndex]) { e.preventDefault(); chooseFeature(items[activeIndex].feature); } }
                else if (e.key === 'Escape') { clearSuggestions(); }
            });

            document.addEventListener('click', e => {
                if (!addressInput.contains(e.target) && !suggestionsBox.contains(e.target)) clearSuggestions();
            });

            addressInput.addEventListener('blur', () => setTimeout(clearSuggestions, 120));
        })();
    </script>
@endsection