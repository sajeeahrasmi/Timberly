<?php
include 'db.php';

// Get POST values with null coalescing for safety
$orderId = $_POST['orderId'] ?? '';
$itemId = $_POST['itemId'] ?? '';
$qty     = $_POST['quantity'] ?? '';

// Basic validation
if (empty($orderId) || empty($itemId) || !is_numeric($qty)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    exit;
}

// Step 1: Update qty in orderlumber
$stmt = $conn->prepare("UPDATE orderlumber SET qty = ? WHERE orderId = ? AND itemId = ?");
$stmt->bind_param("iii", $qty, $orderId, $itemId);

$success1 = $stmt->execute();
$stmt->close();

// Step 2: Update itemQty in orders table
$stmt2 = $conn->prepare("
    UPDATE orders 
    SET itemQty = (
        SELECT SUM(qty) 
        FROM orderlumber 
        WHERE orderId = ?
    ) 
    WHERE orderId = ?
");
$stmt2->bind_param("ii", $orderId, $orderId);

$success2 = $stmt2->execute();
$stmt2->close();

// Final response
if ($success1 && $success2) {
    echo json_encode(['status' => 'success', 'message' => 'Order quantity updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update one or both tables']);
}
?>
