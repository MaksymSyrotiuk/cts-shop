<?php
require "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM players WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password_hash"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["echo_credits"] = $user["echo_credits"];
        header("Location: ../../public/index.php");
    } else {
        echo '<script>
                alert("Incorrect username or password!"); 
                setTimeout(function() { 
                    window.location.href = "../../public/signin.php"; 
                }, 100);
              </script>';
    }
}
?>