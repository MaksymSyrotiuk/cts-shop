<?php

		$host = "localhost"; // Host name
		$dbname = "game_db"; // Name login
		$username = "root"; // DB login
		$password = ""; // Password

		try {
		    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
		    die("Database connection error: " . $e->getMessage());
		}

 ?>