<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <title>Pagina non trovata</title>
    <style>
        :root {
            --image-width: 250px;
        }

        @keyframes easter-egg {
            from {
                right: calc(100vw + var(--image-width));
            }

            to {
                right: calc(var(--image-width) / 2);
            }
        }

        .easter-egg {
            position: fixed;
            bottom: 10px;
            right: calc(100vw + var(--image-width));
        }

        .easter-egg img {
            width: var(--image-width);
        }

        .easter-egg.active {
            animation: easter-egg 1s cubic-bezier(.86, 0, .07, 1) 15s 1 forwards;
        }
    </style>
</head>

<body>
    <h1>Stiamo lavorando per creare questa pagina</h1>
    <img src="https://i.imgur.com/xwfI7Hw.png" alt="mmmmh, error 404">
    <audio src="assets/404.mp3"></audio>
    <h2>Nel frattempo, fai click sulla pagina e apparirà una freccia per tornare allo shopping!</h2>
    <a id="easter" class="easter-egg" href="index.php"><img src="assets/to-be-continued.png" alt="To be continued"></a>

    <script>
        document.addEventListener("click", event => {
            const audio = document.querySelector("audio");
            const easter = document.getElementById("easter");
            audio.volume = 1;
            audio.play();
            easter.classList.add("active")
        });
    </script>
</body>

</html>