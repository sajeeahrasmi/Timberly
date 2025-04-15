<?php
require_once 'db.php';

$orderId = $_POST['orderId'];

$sql = "SELECT ol.qty, l.unitPrice 
        FROM orderlumber ol 
        JOIN lumber l ON ol.itemId = l.lumberId 
        WHERE ol.orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

$totalAmount = 0;
while ($row = $result->fetch_assoc()) {
    $totalAmount += $row['qty'] * $row['unitPrice'];
}
$stmt->close();

$sql = "UPDATE orders SET totalAmount = ? WHERE orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $totalAmount, $orderId);
$stmt->execute();
$stmt->close();

echo json_encode(["status" => "success", "totalAmount" => $totalAmount]);
?>
