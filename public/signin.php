<?php
    require "../src/modules/db.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>
<body>
    <iframe src="../src/modules/audio.html" allow="autoplay"></iframe>
    <nav id="navigation"></nav>

    <!-- Navigation module script-->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("../src/modules/navigation.php") 
            .then(response => response.text())
            .then(html => {
                document.querySelector("#navigation").innerHTML = html;
            });
        });
    </script>   


    <h1>Sign In</h1>
    <h2>You can log into your account here</h2>

    <section class="info-block">
        <h1 class="info-block-h1">Log In</h1>
        <h2 class="description-for-block">It's time to continue shopping in our shop</h2>
        <form action="../src/modules/login.php" method="post">
            <div class="form">
                <div class="block-for-text">
                    <p class="text-for-block">Login</p>
                    <p class="text-for-block">Password</p>
                </div>
                <div class="input-block">
                    <input type="text" name="username" placeholder="Name" required>     
                    <input type="password" name="password" placeholder="Password" required>
                </div>          
            </div>  
            <button type="submit" class="cyber-button">
                Login
            </button>
        </form> 

        <div class="underline" id="sign-up-underline"></div>        
        <div class="underline" id="form-underline"></div>
    </section>

    <script type="module">
        import initializeButtonUnderline from './script/buttonUnderline.js';
        initializeButtonUnderline(".cyber-button", "sign-up-underline");
    </script>
    <script src="script/clickSound.js"  defer></script>

    <footer></footer>
    <!-- Footer module script-->
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
