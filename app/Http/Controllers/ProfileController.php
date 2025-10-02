<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $orders = Order::with('items.product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile.show', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    public function refund(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Exemple simple : on envoie juste un mail admin
        \Mail::raw("Demande de remboursement pour la commande #{$order->id}\n\nRaison : {$request->reason}", function ($message) use ($order) {
            $message->to('contact.ozaena@gmail.com')
                ->subject("Demande de remboursement - Commande #{$order->id}");
        });

        return back()->with('status', 'Votre demande de remboursement a été transmise.');
    }

}
