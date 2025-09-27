<?php
require 'db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Parameters for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9;  // Number of transactions per page
$offset = ($page - 1) * $limit;

try {
    // Count total number of transactions
    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM transactions WHERE user_id = ?");
    $stmtCount->execute([$user_id]);
    $totalTransactions = $stmtCount->fetchColumn();
    
    $totalPages = ceil($totalTransactions / $limit); // Number of pages

    // Fetch transactions for the current page
    $stmt = $pdo->prepare("SELECT t.id, t.item_id, t.total_price, t.item_quantity, t.purchase_time, i.image_url, i.name AS item_name 
                            FROM transactions t
                            JOIN items i ON t.item_id = i.id
                            WHERE t.user_id = ?
                            ORDER BY t.purchase_time DESC
                            LIMIT ? OFFSET ?");
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $limit, PDO::PARAM_INT);
    $stmt->bindParam(3, $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'transactions' => $transactions,
        'current_page' => $page,
        'total_pages' => $totalPages
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error']);
}
?>
