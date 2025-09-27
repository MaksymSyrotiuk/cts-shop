<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require "db.php";
header("Content-Type: application/json");

// Log for debugging
error_log("buy.php was called");

// Get data
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    error_log("Failed to parse JSON: " . file_get_contents("php://input"));
    echo json_encode(["success" => false, "error" => "Invalid JSON input"]);
    exit;
}

$item_id = $data["item_id"] ?? null;
$item_price = $data["item_price"] ?? null;
$quantity = $data["quantity"] ?? 1;
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "error" => "You must be logged in."]);
    exit;
}

if (!$item_id || !$item_price) {
    echo json_encode(["success" => false, "error" => "Invalid item ID or price."]);
    exit;
}

try {
    $pdo->beginTransaction();

    // Check available item quantity
    $checkQuantity = $pdo->prepare("SELECT quantity FROM items WHERE id = ?");
    $checkQuantity->execute([$item_id]);
    $item = $checkQuantity->fetch(PDO::FETCH_ASSOC);

    if (!$item || $item['quantity'] < $quantity) {
        echo json_encode(["success" => false, "error" => "Not enough items in stock"]);
        $pdo->rollBack();
        exit;
    }

    // Get user's balance
    $getBalance = $pdo->prepare("SELECT echo_credits FROM players WHERE id = ?");
    $getBalance->execute([$user_id]);
    $balance = $getBalance->fetch(PDO::FETCH_ASSOC);

    if (!$balance || $balance['echo_credits'] < ($item_price * $quantity)) {
        echo json_encode(["success" => false, "error" => "Not enough credits"]);
        $pdo->rollBack();
        exit;
    }

    // Deduct balance
    $updateCurrency = $pdo->prepare("UPDATE players SET echo_credits = echo_credits - ? WHERE id = ?");
    $updateCurrency->execute([$item_price * $quantity, $user_id]);

    // Reduce item quantity
    $updateQuantity = $pdo->prepare("UPDATE items SET quantity = quantity - ? WHERE id = ?");
    $updateQuantity->execute([$quantity, $item_id]);

    // Add item to inventory (if it already exists, increase the quantity)
    $checkInventory = $pdo->prepare("SELECT quantity FROM inventory WHERE player_id = ? AND item_id = ?");
    $checkInventory->execute([$user_id, $item_id]);
    $inventory = $checkInventory->fetch(PDO::FETCH_ASSOC);

    if ($inventory) {
        // If the item already exists in the inventory, update the quantity
        $updateInventory = $pdo->prepare("UPDATE inventory SET quantity = quantity + ? WHERE player_id = ? AND item_id = ?");
        $updateInventory->execute([$quantity, $user_id, $item_id]);
    } else {
        // If the item doesn't exist, add a new record
        $addItem = $pdo->prepare("INSERT INTO inventory (player_id, item_id, quantity) VALUES (?, ?, ?)");
        $addItem->execute([$user_id, $item_id, $quantity]);
    }

    // Save purchase to transactions
    $saveTransaction = $pdo->prepare("INSERT INTO transactions (user_id, item_id, item_quantity, total_price, purchase_time) VALUES (?, ?, ?, ?, ?)");
    $saveTransaction->execute([$user_id, $item_id, $quantity, $item_price * $quantity, date('Y-m-d H:i:s')]);

    $pdo->commit();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Transaction failed: " . $e->getMessage());
    echo json_encode(["success" => false, "error" => "Transaction failed", "details" => $e->getMessage()]);
}
?>
