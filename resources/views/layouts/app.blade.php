<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ozæna') - Ozaena.fr</title>
    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #0D0D0D;
            color: #F5F5F5;
            font-family: 'Inter', sans-serif;
        }
    
        header,
        footer {
            text-align: center;
            padding: 1rem;
        }
    
        main {
            flex: 1;
            padding: 2rem;
            text-align: center;
        }
    </style>
    

    @stack('styles')
</head>

<body>
    @if (session('status'))
        <script>
            alert("{{ session('status') }}");
        </script>
    @endif
    <header>
        <nav style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem;">
            <a href="{{ url('/') }}" style="text-decoration: none; color: #F5F5F5; font-weight: bold; font-size: 1.2rem;">
                <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" style="height: 72px; width: auto;" />
            </a>
            
    
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="position: relative; display: inline-block; color: #F5F5F5; padding: 0.4rem;">
                    <a href="{{ route('cart.show') }}" title="Panier"
                        style="color: inherit; display: inline-flex; align-items: center; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            style="width: 24px; height: 24px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993
                                             1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125
                                             0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1
                                             5.513 7.5h12.974c.576 0 1.059.435 1.119
                                             1.007ZM8.625 10.5a.375.375 0 1 1-.75 0
                                             .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0
                                             1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                
                        <!-- Badge nombre articles -->
                        <span style="
                                            position: absolute;
                                            top: -6px;
                                            right: -6px;
                                            background-color: red;
                                            color: white;
                                            border-radius: 50%;
                                            padding: 2px 6px;
                                            font-size: 12px;
                                            font-weight: bold;
                                            line-height: 1;
                                            min-width: 18px;
                                            text-align: center;
                                            ">
                            {{ $cartCount }}
                        </span>
                    </a>
                </div>

    
                @auth
                    <a href="{{ route('profile.show') }}" title="Mon profil"
                        style="color: inherit; display: inline-flex; align-items: center; position: relative; padding: 0.4rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                    </a>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit"
                            style="background: none; border: none; color: #F5F5F5; cursor: pointer; font-weight: 600;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                            </svg>

                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="color: #F5F5F5; text-decoration: none; font-weight: 600;">
                        Connectez-vous
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="background-color: #111; color: #ccc; padding: 2rem 1rem; text-align: left;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 2rem; justify-content: flex-start;">
    
            <!-- Réseaux sociaux -->
            <div style="flex: 1 1 200px;">
                <h3 style="color: #F5F5F5; margin-bottom: 1rem;">Réseaux sociaux</h3>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 1.8; display: flex; gap: 0.5rem;">
                    <li>
                        <a href="https://www.instagram.com/ozaena.co/" target="_blank" rel="noopener"
                            style="color: #ccc; text-decoration: none; display: inline-flex; align-items: center; transition: color 0.3s;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="24"
                                height="24" aria-label="Instagram">
                                <path
                                    d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20.5h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3.5h-8.5zm8.75 2a1 1 0 110 2 1 1 0 010-2zm-4.25 1.75a4.75 4.75 0 110 9.5 4.75 4.75 0 010-9.5zm0 1.5a3.25 3.25 0 100 6.5 3.25 3.25 0 000-6.5z" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
    
            <!-- Contact -->
            <div style="flex: 1 1 200px;">
                <h3 style="color: #F5F5F5; margin-bottom: 1rem;">Contact</h3>
                <p>Email : <a href="mailto:contact.ozaena@gmail.com"
                        style="color: #ccc; text-decoration: none;">contact.ozaena@gmail.com</a></p>
                <p>Téléphone : <a href="tel:+33123456789" style="color: #ccc; text-decoration: none;">+33 6 66 63 68 44</a>
                </p>
                <p>Adresse : 519 A LES COREAUX, 68910 LABAROCHE, FRANCE</p>
            </div>
    
            <!-- Mentions légales -->
            <div style="flex: 1 1 300px;">
                <h3 style="color: #F5F5F5; margin-bottom: 1rem;">Mentions légales</h3>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 1.8; display: block;">
                    <li>
                        <a href="{{ route('mentions.legales') }}" style="color: #ccc; text-decoration: underline;">
                            Mentions légales
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cgv') }}" style="color: #ccc; text-decoration: underline;">
                            Conditions Générales de Vente
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    
        <div style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: #666;">
            &copy; {{ date('Y') }} Ozæna. Tous droits réservés.
        </div>
    </footer>    
    
    @stack('scripts')
</body>

</html>