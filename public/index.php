<?php 


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <title>CTS</title>
</head>
<body class=>
    <iframe src="../src/modules/audio.html" allow="autoplay"></iframe>
    <nav id="navigation"></nav>
    <section class="introduction">
        <h1>Cyber Transparent Shop</h1>
        <h2>"Step into the future of shopping."</h2>
        <div class="introduction-block">
            <p class="introduction-text">
                Looking for the gear to survive the chaos? Or<br>
                maybe you’re just here to dominate the streets?<br>
                At Cyber Transporent Shop, you’ll find everything<br> 
                you need: from cutting-edge weapons and rare<br> 
                upgrades to exclusive skins and powerful boosts.
            </p>    
            <div class="underline" id="div-underline"></div>
        </div>
        <a href="signup.php" class="start-button">
            Start
        </a>
        <div class="underline" id="start-button-underline"></div>

        <!-- Navigation module script -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                fetch("../src/modules/navigation.php") 
                .then(response => response.text())
                .then(html => {
                    document.querySelector("#navigation").innerHTML = html;
                });
            });
        </script>

        <script type="module">
            import initializeButtonUnderline from './script/buttonUnderline.js';
            initializeButtonUnderline(".start-button", "start-button-underline");
        </script>

    </section>
    <section class="next">
        <div class="underline" id="start-button-underline"></div>
        <h3>Why shop with us?</h3>
        <p class="about-text">Instant access to premium items.</p>
        <div class="underline" id="about-underline"></div>
        <p class="about-text">Safe and secure transactions.</p>
        <div class="underline" id="about-underline"></div>
        <p class="about-text">Expand your arsenal with ease.</p>
        <div class="underline" id="about-underline"></div>
        <p class="about-text" id="last-text">
            The future is now. Gear up and own the streets.<br>
            Start your journey today!
        </p>
    </section>
    <footer></footer>
    <script src="script/clickSound.js"  defer></script>
    <!-- Footer module script -->
    <script type="module">  
        document.addEventListener("DOMContentLoaded", function () {
            fetch("../src/modules/footer.html") 
            .then(response => response.text())
            .then(html => {
                document.querySelector("footer").innerHTML = html;
            });
        });
    </script>
</body>
</html>
