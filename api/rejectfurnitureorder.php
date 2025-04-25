<?php

require_once 'db.php';


$itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : 0;
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;


if ($itemId <= 0 || $orderId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

/*
$sql = "DELETE FROM orderfurniture WHERE itemId = ? AND orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $itemId, $orderId);
*/

$sql = "SELECT qty, unitPrice FROM orderfurniture WHERE itemId = ? AND orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $itemId, $orderId);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

$itemTotal = $item['qty'] * $item['unitPrice'];

$sql = "UPDATE orderfurniture SET status = 'Not_Approved' WHERE itemId = ? AND orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $itemId, $orderId);
$stmt->execute();


// Step 3: Update totalAmount in orders table
$sql = "UPDATE orders SET totalAmount = GREATEST(totalAmount - ?, 0) WHERE orderId = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $itemTotal, $orderId);
$stmt->execute();



if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Furniture order rejected and deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete furniture order: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>