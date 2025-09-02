@component('mail::message')
# Merci pour votre commande 🎉

Bonjour {{ $order->first_name }} {{ $order->last_name }},
Nous avons bien reçu votre commande **#{{ $order->uuid }}** d’un montant de
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

Si vous souhaitez demander un remboursement, vous pouvez nous contacter dans un délai de 14 jours à
**contact@ozaena.com**, conformément à nos conditions générales de vente (CGV).

---


Nous vous tiendrons informés lorsque votre commande sera expédiée.

Merci de votre confiance,
L’équipe {{ config('app.name') }}
@endcomponent