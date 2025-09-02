@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    <main style="max-width: 900px; margin: 2rem auto; text-align: left;">

        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem;">Mon Profil</h1>

        {{-- Formulaire infos utilisateur --}}
        <section style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.4rem; margin-bottom: 1rem;">Mes informations</h2>
            <form method="POST" action="{{ route('profile.update') }}" style="display: grid; gap: 1rem;">
                @csrf
                @method('PUT')

                <div>
                    <label>Nom :</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        style="width: 100%; padding: 0.5rem; border-radius: 6px;">
                </div>

                <div>
                    <label>Email :</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        style="width: 100%; padding: 0.5rem; border-radius: 6px;">
                </div>

                <div>
                    <label>Nouveau mot de passe :</label>
                    <input type="password" name="password" placeholder="Laisser vide si inchangé"
                        style="width: 100%; padding: 0.5rem; border-radius: 6px;">
                </div>

                <div>
                    <label>Confirmation mot de passe :</label>
                    <input type="password" name="password_confirmation"
                        style="width: 100%; padding: 0.5rem; border-radius: 6px;">
                </div>

                <button type="submit" style="background: #F5F5F5; color: #333; padding: 0.6rem 1.2rem;
                    border-radius: 6px; font-weight: 600;">Mettre à jour</button>
            </form>
        </section>

        {{-- Liste des commandes --}}
        <section>
            <h2 style="font-size: 1.4rem; margin-bottom: 1rem;">Mes commandes</h2>
            @if($orders->isEmpty())
                <p>Vous n’avez pas encore passé de commande.</p>
            @else
                @foreach($orders as $order)
                    <div style="background: #1a1a1a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <p><strong>Commande #{{ $order->uuid }}</strong> – {{ ucfirst($order->status) }} –
                            {{ number_format($order->total, 2, ',', ' ') }} €
                        </p>
                        <p>Adresse : {{ $order->address }}, {{ $order->postal_code }} {{ $order->city }}</p>

                        <ul>
                            @foreach($order->items as $item)
                                <li>{{ $item->product->name }} (x{{ $item->quantity }}) –
                                    {{ number_format($item->unit_price, 2, ',', ' ') }} €
                                </li>
                            @endforeach
                        </ul>

                        {{-- Formulaire remboursement --}}
                        <form method="POST" action="{{ route('profile.refund', $order) }}" style="margin-top: 1rem;">
                            @csrf
                            <label>Demande de remboursement :</label>
                            <textarea name="reason" rows="2" required
                                style="width: 100%; padding: 0.5rem; border-radius: 6px;"></textarea>
                            <button type="submit"
                                style="margin-top: 0.5rem; background: red; color: #fff; padding: 0.4rem 1rem; border-radius: 6px;">
                                Envoyer la demande
                            </button>
                        </form>
                    </div>
                @endforeach
            @endif
        </section>
    </main>
@endsection