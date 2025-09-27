<?php
session_start();
require "../src/modules/db.php"; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
	echo '<script>
            alert("You are not logged in!"); 
            setTimeout(function() { 
                window.location.href = "./signin.php"; 
            }, 10);
           </script>';
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user ID from the session

// Query the player's data
$stmt = $pdo->prepare("SELECT username, level, skill_points, class, weapon, strength, hp_regen, hp, intelligence, stamina, armor, echo_credits, psych_resistance FROM players WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Error: user not found.");
}



// Data update after level up

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['level_up'])) {
        $cost = $user['level'] * 5;
        if ($user['echo_credits'] >= $cost) {
            $stmt = $pdo->prepare("UPDATE players SET level = level + 1, skill_points = skill_points + 5, echo_credits = echo_credits - ? WHERE id = ?");
            $stmt->execute([$cost, $user_id]);
            header("Location: ./stats.php");
            exit();
        }
    } elseif (isset($_POST['upgrade_stat'])) {
        $stat = $_POST['upgrade_stat'];  
        $allowed_stats = ['strength', 'hp_regen', 'hp', 'intelligence', 'stamina', 'armor', 'psych_resistance'];

        if (in_array($stat, $allowed_stats) && $user['skill_points'] > 0) {
            $stmt = $pdo->prepare("UPDATE players SET $stat = $stat + 1, skill_points = skill_points - 1 WHERE id = ?");
            $stmt->execute([$user_id]);
            header("Location: stats.php");
            exit();
        }
    }
}

// Visability function for skill buttons
$visability = ($user['skill_points'] <= 0) ? 'display: none;' : 'display: block;';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <title>Statistics</title>
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



    <h1>Stats</h1>
    <h2>You can see your statistics here</h2>

    <section class="info-block">
        <h1 class="info-block-h1">Character information</h1>
        <h2 class="description-for-block stats-description">Let's see how far you've come</h2>
        <h2 class="description-for-block text-name" >Name: <?php echo htmlspecialchars($user['username']); ?></h2>
        <h2 class="description-for-block text-name" >Skill points: <?php echo htmlspecialchars($user['skill_points']); ?></h2>
        <div class="form" id="stat-block">
            <div class="lvl-block">
                <p class="text-for-block">LVL: <?php echo htmlspecialchars($user['level']); ?></p>
        			<div class="lvl-underline">
        			<form method="post" style="display:inline;">
            				<button class="cyber-button" id="lvl-button" type="submit" name="level_up" <?php echo ($user['echo_credits'] < $user['level'] * 5) ? 'disabled' : ''; ?>>
                				LVL UP
            				</button>
        					<div class="underline" id="sign-up-underline"></div>      
        			</form>	
        			</div>
        			<p class="text-for-block" style="font-size:0.8em; margin: auto 0;"><?php echo $user['level'] * 5; ?> Echo Credits</p>

            </div>
            <div class="character-stats">
                <div class="first-stats-block">
                   <div class="block-for-text">
                       <p class="text-for-block" id="stats-info">Class:</p>
                       <p class="text-for-block" id="stats-info">Strength:</p>
                       <p class="text-for-block" id="stats-info">HP:</p>
                       <p class="text-for-block" id="stats-info">Stamina:</p>
                       <p class="text-for-block" id="stats-info">Echo Credits:</p>
                   </div>
                   <div class="block-for-text value-stats-block">
                       <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['class']); ?></p>
                       <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['strength']); ?></p>
                       <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['hp']); ?></p>
                       <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['stamina']); ?></p>
                       <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['echo_credits']); ?></p>
                   </div> 
                   <div class="block-for-text" id="add-skill-button">
                        <form method="post" style="<?php echo $visability?>">
                               <button style="visibility: hidden;" class="cyber-button" id="skill-button">
                                   +
                               </button>
                               <div class="underline" id="sign-up-underline" style="visibility: hidden;"></div>  
                       </form>
                        <form method="post" style="<?php echo $visability?>">
                               <button type="submit" name="upgrade_stat" value="strength" onclick="playSound('statUpgradeSound')" <?php echo ($user['skill_points'] <= 0) ? 'disabled' : ''; ?> class="cyber-button" id="skill-button">
                                   +
                               </button>
                               <div class="underline" id="sign-up-underline"></div>  
                       </form>
                        <form method="post" style="<?php echo $visability?>">
                               <button type="submit" name="upgrade_stat" value="hp"  class="cyber-button" id="skill-button">
                                   +
                               </button>
                               <div class="underline" id="sign-up-underline"></div>  
                       </form>
                        <form method="post" style="<?php echo $visability?>">
                               <button type="submit" name="upgrade_stat" value="stamina" class="cyber-button" id="skill-button">
                                   +
                               </button>
                               <div class="underline" id="sign-up-underline"></div>  
                       </form>
                        <form method="post" style="visibility: hidden;">
                               <button type="submit" name="upgrade_stat" class="cyber-button" id="skill-button">
                                   +
                               </button>
                               <div class="underline" id="sign-up-underline"></div>  
                       </form>                                                                                                 
                   </div>                     
                </div>
                <div class="second-stats-block">
                 <div class="block-for-text">
                     <p class="text-for-block" id="stats-info">Weapon: </p>
                     <p class="text-for-block" id="stats-info">HP-Regen: </p>
                     <p class="text-for-block" id="stats-info">Intelligence: </p>
                     <p class="text-for-block" id="stats-info">Armor: </p>
                     <p class="text-for-block" id="stats-info">Psych Resistance: </p>
                 </div> 
                 <div class="block-for-text">
                     <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['weapon']); ?></p>
                     <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['hp_regen']); ?></p>
                     <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['intelligence']); ?></p>
                     <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['armor']); ?></p>
                     <p class="text-for-block" id="stats-info"><?php echo htmlspecialchars($user['psych_resistance']); ?></p>
                 </div>  
                 <div class="block-for-text" id="add-skill-button">
                      <form method="post" style="<?php echo $visability?>">
                             <button style="visibility: hidden;" class="cyber-button" id="skill-button">
                                 +
                             </button>
                             <div class="underline" id="sign-up-underline" style="visibility: hidden;"></div>  
                     </form>
                      <form method="post" style="<?php echo $visability?>">
                             <button type="submit" name="upgrade_stat" value="hp_regen" <?php echo ($user['skill_points'] <= 0) ? 'disabled' : ''; ?> class="cyber-button" id="skill-button">
                                 +
                             </button>
                             <div class="underline" id="sign-up-underline"></div>  
                     </form>
                      <form method="post" style="<?php echo $visability?>">
                             <button type="submit" name="upgrade_stat" value="intelligence"  class="cyber-button" id="skill-button">
                                 +
                             </button>
                             <div class="underline" id="sign-up-underline"></div>  
                     </form>
                      <form method="post" style="<?php echo $visability?>">
                             <button type="submit" name="upgrade_stat" value="armor" class="cyber-button" id="skill-button">
                                 +
                             </button>
                             <div class="underline" id="sign-up-underline"></div>  
                     </form>
                      <form method="post" style="<?php echo $visability?>">
                             <button type="submit" name="upgrade_stat" value="psych_resistance" class="cyber-button" id="skill-button">
                                 +
                             </button>
                             <div class="underline" id="sign-up-underline"></div>  
                     </form>                                                                                                 
                   </div>                                          
                </div>
            </div>
        </div>  
        <div class="underline" id="form-underline"></div>
    </section>

    <script type="module">
        import initializeButtonUnderline from './script/buttonUnderline.js';
        initializeButtonUnderline(".cyber-button", "sign-up-underline");
    </script>

    <footer></footer>
    <script src="script/clickSound.js"  defer></script>
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
