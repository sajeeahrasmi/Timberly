<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userId'])) {
    echo json_encode(['error' => 'User not logged in']);
    http_response_code(401);
    exit;
}

$userId = $_SESSION['userId'];
$data = json_decode(file_get_contents('php://input'), true);
$productId = intval($data['productId']);

if (!$productId) {
    echo json_encode(['error' => 'Invalid product ID']);
    http_response_code(400);
    exit;
}

// Check if already in cart, increase qty if needed
$checkQuery = "SELECT * FROM cart WHERE userId = ? AND productId = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param('ii', $userId, $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Already in cart, increment quantity
    $updateQuery = "UPDATE cart SET qty = qty + 1 WHERE userId = ? AND productId = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ii', $userId, $productId);
    $stmt->execute();
} else {
    // Insert new cart item
    $insertQuery = "INSERT INTO cart (productId, userId, qty, selectToOrder) VALUES (?, ?, 1, 'no')";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param('ii', $productId, $userId);
    $stmt->execute();
}

echo json_encode(['success' => true]);
?>