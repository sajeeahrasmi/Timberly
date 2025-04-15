<?php
require_once 'db.php';

$orderId = $_POST['orderId'];
$dfree = $_POST['dfree'] ?? 0; // Default to 0 if not set

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
$totalAmount += $dfree; // Add the delivery fee if applicable
$sql = "UPDATE orders SET totalAmount = ? WHERE orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $totalAmount, $orderId);
$stmt->execute();
$stmt->close();

echo json_encode(["status" => "success", "totalAmount" => $totalAmount]);
?>
