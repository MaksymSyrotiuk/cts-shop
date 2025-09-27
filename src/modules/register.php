<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $gender = $_POST["gender"];
    $birth_date = $_POST["birth_date"];

    // Age check (16+ years)
    $birth_timestamp = strtotime($birth_date);
    $min_age_timestamp = strtotime("-16 years");

    if ($birth_timestamp > $min_age_timestamp) {
        echo '<script>alert("You must be older than 16 years to register!"); window.history.back();</script>';
        exit;
    }

    try {
        // Check for existing username or email
        $check_sql = "SELECT COUNT(*) FROM players WHERE username = :username OR email = :email";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([":username" => $username, ":email" => $email]);
        $existing_count = $check_stmt->fetchColumn();

        if ($existing_count > 0) {
            echo '<script>alert("Username or email is already taken!"); window.history.back();</script>';
            exit;
        }

        // Password hashing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user
        $sql = "INSERT INTO players (username, email, password_hash, gender, birth_date) 
                VALUES (:username, :email, :password, :gender, :birth_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":username" => $username,
            ":email" => $email,
            ":password" => $hashed_password,
            ":gender" => $gender,
            ":birth_date" => $birth_date
        ]);

        echo '<script>
                alert("Registration successful!"); 
                setTimeout(function() { 
                    window.location.href = "../start.php"; 
                }, 100);
              </script>';
    } catch (PDOException $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
    }
}
?>
