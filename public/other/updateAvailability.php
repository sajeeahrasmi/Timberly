<?php
session_start();
header('Content-Type: application/json');
require '../../config/db_connection.php';

if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$driverId = $_SESSION['userId'];

// Decode current status from frontend
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit();
}

$currentStatus = $data['currentStatus'] ?? 'NO';
$newStatus = ($currentStatus === 'YES') ? 'NO' : 'YES';

// Update the driver availability
$stmt = $conn->prepare("UPDATE driver SET available = ? WHERE driverId = ?");
$stmt->bind_param("si", $newStatus, $driverId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'newStatus' => $newStatus]);
} else {
    echo json_encode(['success' => false, 'message' => 'DB update failed']);
}
?>
