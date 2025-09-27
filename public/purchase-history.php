<?php

session_start();
// Include the database connection module
require "../src/modules/db.php";

if (!isset($_SESSION['user_id'])) {
    echo '<script>
            alert("You are not logged in!"); 
            setTimeout(function() { 
                window.location.href = "./signin.php"; 
            }, 10);
           </script>';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <title>Purchase-history</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    <script type="text/javascript">const userId = <?= json_encode($_SESSION['user_id'] ?? null) ?>;</script>
</head>
<body class="history-body">
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


    <h1 class="ada">Purchase History</h1>
    <h2>You can see your purchase history here</h2>

    <section class="info-block transaction-section">
        <div class="shop-block transaction-untersection">  

        </div>
        <div class="pagination transaction-pagination">
            <button class = "page-switcher" ><</button>
            <p class="introduction-text page-text">1/5</p>
            <button class = "page-switcher">></button>
        </div>
        <div class="underline" id="form-underline"></div>   
    </section>

    <script type="module">
        import initializeButtonUnderline from './script/buttonUnderline.js';
    </script>

    <script src="script/loadTransactions.js"></script>



           




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

</body>
</html>
