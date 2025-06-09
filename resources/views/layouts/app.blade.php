<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ozæna')</title>

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

        .header-3d {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 16rem;
            position: relative;
        }

        .logo-container {
            position: relative;
            width: 13rem;
            height: 13rem;
            perspective: 1000px;
        }

        .logo-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 80%;
            height: 80%;
            animation: spin 7s linear infinite;
            transform-style: preserve-3d;
        }

        @keyframes spin {
            from {
                transform: rotateY(0deg);
            }

            to {
                transform: rotateY(360deg);
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <header class="header-3d">
        <div class="logo-container">
            <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" class="logo-layer"/>
        </div>
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