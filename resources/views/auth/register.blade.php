@extends('layouts.app')

@section('title', 'Inscription')

@push('styles')
    <style>
        form {
            max-width: 400px;
            margin: 2rem auto;
            text-align: left;
            background: #1a1a1a;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgb(0 0 0 / 0.5);
            color: #ddd;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #ddd;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border-radius: 6px;
            border: 1.5px solid #333;
            background: #0d0d0d;
            color: #eee;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #f5f5f5;
            box-shadow: 0 0 6px #f5f5f5;
            background: #1a1a1a;
        }

        button[type="submit"] {
            width: 100%;
            padding: 0.85rem;
            background-color: #f5f5f5;
            color: #0d0d0d;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 1.5rem;
        }


        button[type="submit"]:hover {
            background-color: #ddd;
        }

        p.text-center {
            text-align: center;
            margin-top: 1.5rem;
            color: #ccc;
            font-size: 0.95rem;
        }

        p.text-center a {
            color: #f5f5f5;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        p.text-center a:hover {
            color: #ddd;
        }
    </style>
@endpush

@section('content')
    <h1 style="text-align:center; margin-top: 2rem; font-weight: 800; color: #f5f5f5;">Créer un compte</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Nom</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

        <label for="email" style="margin-top: 1rem;">Adresse e-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

        <label for="password" style="margin-top: 1rem;">Mot de passe</label>
        <input id="password" type="password" name="password" required>

        <label for="password_confirmation" style="margin-top: 1rem;">Confirmer le mot de passe</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit">S'inscrire</button>
    </form>

    <p class="text-center">
        Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous ici</a>.
    </p>
@endsection