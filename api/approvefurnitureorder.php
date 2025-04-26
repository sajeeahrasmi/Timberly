<?php

require_once 'db.php';


$itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : 0;
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;


if ($itemId <= 0 || $orderId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}


$sql = "UPDATE orderfurniture SET status = 'Approved' WHERE itemId = ? AND orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $itemId, $orderId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Furniture order approved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to approve furniture order: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>