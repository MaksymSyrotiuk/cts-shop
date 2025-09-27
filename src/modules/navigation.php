<?php 
    session_start();
    require "db.php";
    if (isset($_SESSION["user_id"])) {
            $userId = $_SESSION["user_id"];
    
    // Query the database to get a fresh balance
            $stmt = $pdo->prepare("SELECT echo_credits FROM players WHERE id = ?");
            $stmt->execute([$userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                $_SESSION["echo_credits"] = $row["echo_credits"];
            }
    }
?>



<label for="menu-switcher">
    <header>
        <i>&#xf20d;</i>
    </header>
</label>
<img src="media/Logo.svg" id="logo">
<nav-menu>
    <menu-head>
        <a class="menu-site" id="start-nav" href="index.php">Start</a>
    </menu-head>
</nav-menu>

<nav-menu>
    <menu-head class="nav-shop-button">
        <a class="menu-site" id="shop-nav" href="shop.php">Shop</a>
    </menu-head>
</nav-menu>

<nav-menu class="under-menu">
    <menu-head>
        <a class="menu-site">Character ⯆</a>
    </menu-head>
    <menu-body>
        <div class="menu-item">
            <a class="selection" id="inventory-nav" href="inventory.php">Inventory</a>
            <div class="underline" id="navigation-underline"></div>
        </div>
        <div class="menu-item">
            <a class="selection" id="stats-nav" href="stats.php" href="">Stats</a>
            <div class="underline" id="navigation-underline"></div>
        </div>
        <div class="menu-item">
            <a class="selection" id="purchase-history-nav" href="purchase-history.php">Purchase History</a>
            <div class="underline" id="navigation-underline"></div>
        </div>
    </menu-body>
</nav-menu>

<?php if (isset($_SESSION["user_id"])): ?>
    <!-- Show user nickname, currency and exit button -->
    <nav-menu class="sign-in-nav">
        <menu-head>
            <span class="menu-site">👤 <?php echo $_SESSION["username"]; ?></span>
        </menu-head>
    </nav-menu>

    <nav-menu>
        <menu-head>
            <img src="media/EC.svg" class="navigation-currency" alt="">
            <a class="menu-site" id="sign-up-nav" href="#"><?php echo $_SESSION["echo_credits"]; ?></a>
        </menu-head>
    </nav-menu>

    <nav-menu>
        <menu-head>
            <a class="menu-site" href="../src/modules/logout.php">Logout</a>
            <div class="underline" id="navigation-underline"></div>
        </menu-head>
    </nav-menu>
<?php else: ?>
    <!-- If the user is NOT logged in, we show Sign In and Sign Up -->
    <nav-menu class="sign-in-nav">
        <menu-head>
            <a class="menu-site" id="sign-in-nav" href="signin.php">Sign In</a>
            <div class="underline" id="navigation-underline"></div>
        </head>
    </nav-menu>

    <nav-menu>
        <menu-head>
            <a class="menu-site" id="sign-up-nav" href="signup.php">Sign Up</a>
            <div class="underline" id="navigation-underline"></div>
        </menu-head>
    </nav-menu>
<?php endif; ?>

<div class="underline" id="navigation-div-underline"></div>
