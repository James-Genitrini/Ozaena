<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ouverture bientôt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .coming-soon-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            gap: 2rem;
            padding: 2rem;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        #countdown {
            font-size: 2rem;
            background-color: #222;
            padding: 1rem 2rem;
            border-radius: 10px;
            border: 1px solid #444;
        }

        .logo-container {
            width: 13rem;
            height: 13rem;
            perspective: 1000px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-layer {
            width: 60%;
            height: 60%;
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

        @media (max-width: 640px) {
            h1 {
                font-size: 2rem;
            }

            #countdown {
                font-size: 1.5rem;
                padding: 0.75rem 1.5rem;
            }

            .logo-container {
                width: 10rem;
                height: 10rem;
            }
        }
    </style>
</head>

<body>
    <div class="coming-soon-container">
        <div class="logo-container">
            <img src="{{ asset('images/500_logo.png') }}" alt="Ozaena logo" class="logo-layer" />
        </div>

        <h1>Notre site ouvre bientôt 🚀</h1>

        <div id="countdown"></div>
        <p>Restez connecté, nous serons en ligne très bientôt !</p>
    </div>

    <script>
        // Timestamp exact du site (millisecondes)
        let openingDate = {{ $openingDateTimestamp }};

        let timer = setInterval(function () {
            let now = Date.now(); // UTC côté client
            let distance = openingDate - now;

            if (distance < 0) {
                clearInterval(timer);
                window.location.href = "/"; // redirection vers la home
            } else {
                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    days + "j " + hours + "h " + minutes + "m " + seconds + "s ";
            }
        }, 1000);
    </script>
</body>

</html>