<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ozæna')</title>
    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
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
                <button title="Panier" style="background: none; border: none; cursor: pointer; padding: 0.4rem; color: #F5F5F5;">
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
                </button>
    
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit"
                            style="background: none; border: none; color: #F5F5F5; cursor: pointer; font-weight: 600;">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="color: #F5F5F5; text-decoration: none; font-weight: 600;">
                        Login
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Ozæna</p>
    </footer>

    @stack('scripts')
</body>

</html>