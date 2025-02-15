<?php
header('Content-Type: application/json');
include 'db.php'; // Ensure this correctly connects to your database

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['orderId']) || !isset($data['newStatus'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$orderId = $data['orderId'];
$newStatus = $data['newStatus'];

// Check if new status is 'Pending'
if ($newStatus === 'Pending') {
    // Delete query if status is 'Pending'
    $sql = "DELETE FROM orderlumber WHERE orderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order deleted because status is 'Pending'"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }
} else {
    // Update query if status is not 'Pending'
    $sql = "UPDATE orderlumber SET status = ? WHERE orderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $orderId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order status updated"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }
}

$stmt->close();
$conn->close();
?>
