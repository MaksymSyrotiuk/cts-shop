<?php

// Include the database connection module
require "db.php";

// Set the number of items to display per page
$items_per_page = 9;

// Get the current page number from the URL parameter, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $items_per_page;

// Get the total number of items
$total_items_stmt = $pdo->query("SELECT COUNT(*) FROM items");
$total_items = $total_items_stmt->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_items / $items_per_page);

// Get the items for the current page
$stmt = $pdo->prepare("SELECT * FROM items LIMIT ? OFFSET ?");
$stmt->bindValue(1, $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send the JSON response
echo json_encode([
    "items" => $items,
    "total_pages" => $total_pages,
    "current_page" => $page
]);

?>