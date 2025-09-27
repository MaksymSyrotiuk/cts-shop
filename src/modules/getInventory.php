<?php
require 'db.php';
session_start();

header('Content-Type: application/json');

// Check for active session and user_id presence
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'error' => 'User not authenticated',
        'session_status' => session_status(),
        'session_data' => $_SESSION
    ]);
    exit;
}

$player_id = $_SESSION['user_id']; // Use player_id from session

// Check if the player ID is a number
if (!is_numeric($player_id)) {
    echo json_encode([
        'error' => 'Invalid player ID in session',
        'player_id' => $player_id
    ]);
    exit;
}

// Check if the 'id' parameter is set to get data for a specific item
if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Get the ID from the request

    try {
        // Get data for a specific item from the items table
        $stmt = $pdo->prepare("SELECT * FROM items WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            echo json_encode($item); // Return item data
        } else {
            echo json_encode(["error" => "Item not found"]); // Error if item not found
        }
    } catch (PDOException $e) {
        echo json_encode([
            'error' => 'Database error',
            'details' => $e->getMessage()
        ]);
    }
    exit; // End script execution if 'id' parameter is provided
}

// Pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9; // Number of items per page
$offset = ($page - 1) * $limit;

try {
    // Get the total number of items for the player
    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM inventory WHERE player_id = ?");
    $stmtCount->execute([$player_id]);
    $totalItems = $stmtCount->fetchColumn();
    $totalPages = ceil($totalItems / $limit);

    // Get the player's items with pagination
    $stmt = $pdo->prepare("
        SELECT i.id, i.name, i.image_url, inv.quantity
        FROM inventory inv
        JOIN items i ON inv.item_id = i.id
        WHERE inv.player_id = ?
        LIMIT ? OFFSET ?
    ");
    
    $stmt->bindParam(1, $player_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $limit, PDO::PARAM_INT);
    $stmt->bindParam(3, $offset, PDO::PARAM_INT);
    $stmt->execute();

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'items' => $items,
        'current_page' => $page,
        'total_pages' => $totalPages,
        'debug' => [
            'player_id' => $player_id,
            'total_items' => $totalItems
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}
?>
