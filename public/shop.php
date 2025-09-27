<?php

session_start();
// Include the database connection module
require "../src/modules/db.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <script type="text/javascript">const userId = <?= json_encode($_SESSION['user_id'] ?? null) ?>;</script>
</head>
<body>
     <iframe src="../src/modules/audio.html" allow="autoplay"></iframe>
    <nav id="navigation"></nav>

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

    <h1>Shop</h1>
    <h2>It's time to stock up!</h2>

    <section class="info-block item-info-block">
        <div class="shop-block">
            <div class="items-zone">
                <h1 class="info-block-h1 item-h1">Items</h1>   
                <div class="block-for-items">
                                                  
                </div>
                <div class="pagination">
                    <button class = "page-switcher" ><</button>
                    <p class="introduction-text page-text">1/5</p>
                    <button class = "page-switcher">></button>
                </div>
            </div>
            <div class="detailed-description">
                <h1 class="info-block-h1 item-h1 big-item-name">Item</h1> 
                <div class="big-block-item">
                    <div class="underline" id="item-underline"></div>
                    <img src="" class="big-item-image background-image" alt="">
                    <div class="value-item">
                        <img src="media/EC.svg" class="ec">
                        <p class="text-for-block big-item-price"></p>
                    </div>
                </div>  
                <div class="count-block">
                    <button class="count-button">-</button>
                    <p class="introduction-text big-item-count"></p>
                    <button class="count-button">+</button>
                </div>
                <div class="big-item-info">
                        <p class="introduction-text buff-info"> </p>
                </div>
                <p class='introduction-text item-description'></p>
                <button type="submit" class="cyber-button shop-button" data-item-id = "1">
                Buy
                </button>
                <div class="underline" id="sign-up-underline"></div>

            </div>            
        </div>
        <div class="underline" id="form-underline"></div>   
    </section>

    <script type="module">
        import initializeButtonUnderline from './script/buttonUnderline.js';
    </script>
        




    <footer></footer>
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
    <script src="script/clickSound.js"  defer></script>
    <script src="script/shopScript.js" type="module" defer></script>
</body>
</html>
