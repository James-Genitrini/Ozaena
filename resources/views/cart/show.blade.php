@extends('layouts.app')

@section('title', 'Mon panier')

@push('styles')
    <style>
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            color: #ddd;
        }

        .cart-table th,
        .cart-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #444;
            text-align: left;
        }

        .cart-table th {
            border-bottom: 2px solid #666;
        }

        .btn-remove {
            background-color: #a00;
            color: #fff;
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-remove:hover {
            background-color: #d33;
        }

        input[type="number"] {
            width: 60px;
            padding: 0.3rem 0.5rem;
            border-radius: 4px;
            border: 1px solid #666;
            background-color: #111;
            color: #ddd;
            text-align: center;
        }

        .empty-cart {
            text-align: center;
            padding: 4rem 0;
            font-size: 1.25rem;
            color: #bbb;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto mt-12 px-6">
        @if ($cart && $cart->items->count() > 0)
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Taille</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->items as $item)
                        <tr data-product-slug="{{ $item->product->slug }}" data-size="{{ $item->size }}">
                            <td class="flex items-center gap-4">
                                <img src="{{ asset($item->product->main_image_front) }}" alt="{{ $item->product->name }}"
                                    class="w-16 h-16 object-cover rounded" />
                                <a href="{{ route('produit.show', $item->product->slug) }}" class="font-semibold hover:underline text-white">
                                    {{ $item->product->name }}
                                </a>
                            </td>
                            <td>{{ $item->size }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', [$item->product]) }}"
                                    class="update-quantity-form" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="selected_size" value="{{ $item->size }}">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                        class="quantity-input" />
                                </form>
                            </td>
                            <td>€{{ number_format($item->product->price, 2) }}</td>
                            <td class="item-total">€{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-bold">Total général :</td>
                        <td colspan="2" class="font-semibold" id="cart-grand-total">
                            €{{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            @if ($cart && $cart->items->count() > 0)
                <div class="mt-6 text-right">
                    <a href="{{ route('checkout.show') }}"
                        class="inline-block bg-green-600 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded transition-colors">
                        Passer au paiement
                    </a>
                </div>
            @endif

        @else
            <p class="empty-cart">Votre panier est vide.</p>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.update-quantity-form');

            forms.forEach(form => {
                const input = form.querySelector('.quantity-input');

                input.addEventListener('change', function () {
                    input.disabled = true;

                    const url = form.getAttribute('action');
                    const quantity = input.value;
                    const size = form.querySelector('input[name="selected_size"]').value;
                    const productSlug = form.closest('tr').dataset.productSlug;

                    const formData = new FormData();
                    formData.append('_method', 'PATCH');
                    formData.append('_token', form.querySelector('input[name="_token"]').value);
                    formData.append('quantity', quantity);
                    formData.append('selected_size', size);

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Erreur réseau');
                            return response.json();
                        })
                        .then(data => {
                            // Met à jour le total de la ligne
                            const tr = form.closest('tr');
                            const priceUnit = parseFloat(tr.querySelector('td:nth-child(4)').textContent.replace('€', '').replace(',', '.'));
                            const newTotal = (priceUnit * quantity).toFixed(2);
                            tr.querySelector('.item-total').textContent = `€${newTotal}`;

                            // Met à jour le total général
                            if (data.cart_total) {
                                document.getElementById('cart-grand-total').textContent = `€${parseFloat(data.cart_total).toFixed(2)}`;
                            }

                            console.log('Quantité mise à jour avec succès', data);
                        })
                        .catch(error => {
                            console.error('Erreur lors de la mise à jour:', error);
                            alert('Erreur lors de la mise à jour de la quantité.');
                        })
                        .finally(() => {
                            input.disabled = false;
                        });
                });
            });
        });
    </script>
@endpush