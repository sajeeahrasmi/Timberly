<?php
session_start();

if (!isset($_SESSION['userId'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

include '../../config/db_connection.php';

$userId = $_SESSION['userId'];
$orders = [];

function fetchOrders($conn, $table, $columns, $driverId) {
    $query = "SELECT $columns FROM $table WHERE driverId = ? AND status = 'pending'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$orders = array_merge(
    fetchOrders($conn, "orderfurniture", "orderId, itemId, type, description, qty, date", $userId),
    fetchOrders($conn, "ordercustomizedfurniture", "orderId, itemId, type, details AS description, qty, date", $userId),
    fetchOrders($conn, "orderlumber", "orderId, itemId, 'Lumber' AS type, 'Lumber Order' AS description, qty, date", $userId)
);

echo json_encode($orders);
?>
