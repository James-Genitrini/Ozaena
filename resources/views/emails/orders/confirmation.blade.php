@component('mail::message')
# Merci pour votre commande 🎉

Bonjour {{ $order->first_name }} {{ $order->last_name }},

Nous avons bien reçu votre commande **#{{ $order->id }}** d’un montant de
**{{ number_format($order->total, 2, ',', ' ') }} €**.

## Détails de la commande :
@foreach($order->items as $item)
    - {{ $item->product->name }} (x{{ $item->quantity }}) – {{ number_format($item->unit_price, 2, ',', ' ') }} €
@endforeach

**Adresse de livraison :**
{{ $order->address }}
{{ $order->postal_code }} {{ $order->city }}
{{ $order->country }}

---

Nous vous tiendrons informés lorsque votre commande sera expédiée.

Merci de votre confiance,
L’équipe {{ config('app.name') }}
@endcomponent