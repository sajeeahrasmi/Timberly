<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userId']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized or invalid request']);
    exit();
}

include '../../config/db_connection.php';

$driverId = $_SESSION['userId'];

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

$orderId = $data['orderId'] ?? null;
$location = $data['location'] ?? null;

if (!$orderId || !$location) {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit();
}

// Get the customerId from orders table (it's actually userId)
$stmt = $conn->prepare("SELECT userId FROM orders WHERE orderId = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
    exit();
}

$customerId = $result->fetch_assoc()['userId'];

// Insert into trackDriveLocation
$insertStmt = $conn->prepare("INSERT INTO trackDriveLocation (orderId, customerId, driverId, location) VALUES (?, ?, ?, ?)");
$insertStmt->bind_param("iiis", $orderId, $customerId, $driverId, $location);
$insertStmt->execute();

// Send customer notification
$message = "Delivery has started. Track the location here: $location";
$fromWhom = "Driver";

$notifStmt = $conn->prepare("INSERT INTO customerNotification (userId, fromId, fromWhom, message, view) VALUES (?, ?, ?, ?, 0)");
$notifStmt->bind_param("iiss", $customerId, $driverId, $fromWhom, $message);
$notifStmt->execute();

echo json_encode(['success' => true, 'message' => 'Delivery started and customer notified']);
?>
