<?php
require_once 'db.php';

$orderId = $_POST['orderId'];
$dfree = $_POST['dfree'] ?? 0;

$saveDfreeSql = "UPDATE orders SET deliveryFee = ? WHERE orderId = ?";
$saveStmt = $conn->prepare($saveDfreeSql);
$saveStmt->bind_param("di", $dfree, $orderId);
$saveStmt->execute();
$saveStmt->close();
$sql = "SELECT ol.qty, l.unitPrice 
        FROM orderlumber ol 
        JOIN lumber l ON ol.itemId = l.lumberId 
        WHERE ol.orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

$totalAmount = 0;
$itemCount = 0;

while ($row = $result->fetch_assoc()) {
    $totalAmount += $row['qty'] * $row['unitPrice'];
    $itemCount++; 
}
$stmt->close();


$totalAmount += $dfree * $itemCount;


$sql = "SELECT SUM(amount) as totalpaid FROM payment WHERE orderId = ? AND viewed = '1'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$result = $result->fetch_assoc();
$totalpaid = $result['totalpaid'] ?? 0; 

$totalAmount = $totalAmount - $totalpaid; 

$sql = "UPDATE orders SET totalAmount = ? WHERE orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $totalAmount, $orderId);
$stmt->execute();
$stmt->close();

echo json_encode(["status" => "success", "totalAmount" => $totalAmount]);
?>
