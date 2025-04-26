<?php

require_once 'db.php';

$itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : 0;
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;

if ($itemId <= 0 || $orderId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}


$sql = "SELECT qty, unitPrice FROM ordercustomizedfurniture WHERE itemId = ? AND orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $itemId, $orderId);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();
$stmt->close();

if (!$item) {
    echo json_encode(['status' => 'error', 'message' => 'Item not found']);
    $conn->close();
    exit;
}

$itemTotal = $item['qty'] * $item['unitPrice'];


$sql = "UPDATE ordercustomizedfurniture SET status = 'Not_Approved' WHERE itemId = ? AND orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $itemId, $orderId);
$stmt->execute();
$stmt->close();


$sql = "UPDATE orders SET totalAmount = GREATEST(totalAmount - ?, 0) WHERE orderId = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $itemTotal, $orderId);
$stmt->execute();
$stmt->close();

echo json_encode(['status' => 'success', 'message' => 'Furniture order rejected successfully']);

$conn->close();
?>
