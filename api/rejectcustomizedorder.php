<?php
// Include database connection
require_once 'db.php';

// Get parameters
$itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : 0;
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;

// Check if parameters are valid
if ($itemId <= 0 || $orderId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

// Delete the furniture order record
$sql = "DELETE FROM ordercustomizedfurniture WHERE itemId = ? AND orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $itemId, $orderId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Furniture order rejected and deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete furniture order: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>