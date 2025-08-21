@extends('layouts.app')

@section('title', 'Commandes')

@section('content')
    <div style="max-width: 900px; margin: 0 auto; padding: 2rem;">
        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; color: #F5F5F5; text-align: center;">
            Commandes</h2>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; color: #F5F5F5;">
                <thead>
                    <tr style="border-bottom: 2px solid #333;">
                        <th style="text-align: left; padding: 0.75rem;">ID</th>
                        <th style="text-align: left; padding: 0.75rem;">Utilisateur</th>
                        <th style="text-align: left; padding: 0.75rem;">Total</th>
                        <th style="text-align: left; padding: 0.75rem;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr style="border-bottom: 1px solid #222;">
                            <td style="padding: 0.75rem;">{{ $order->id }}</td>
                            <td style="padding: 0.75rem;">{{ $order->user->name ?? 'Inconnu' }}</td>
                            <td style="padding: 0.75rem;">{{ $order->total }} €</td>
                            <td style="padding: 0.75rem;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem; text-align: center; color: #F5F5F5;">
            {{ $orders->links() }}
        </div>
    </div>
@endsection