<?php
// Include the database connection (assuming it's in the same directory)
require_once 'db.php';

// Get the orderId and itemId from the URL
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
$itemId = isset($_GET['itemId']) ? $_GET['itemId'] : '';

// Fetch the details of the specific item from the database
$sql = "
    SELECT 
        o.orderId, 
        o.date, 
        o.totalAmount, 
        o.status AS orderStatus,
        ol.itemId, 
        u.name AS customerName, 
        u.email,
        u.address,
        u.phone,
        ol.qty, 
        ol.status AS itemStatus, 
        l.unitPrice,
        CONCAT(l.type, ' (', ol.qty, ')') AS typeQty 
    FROM orderlumber ol
    LEFT JOIN orders o ON ol.orderId = o.orderId
    LEFT JOIN user u ON o.userId = u.userId
    LEFT JOIN lumber l ON ol.itemId = l.lumberId
    WHERE o.orderId = ? AND ol.itemId = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $orderId, $itemId);
$stmt->execute();
$result = $stmt->get_result();

$orderDetails = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }
}

$stmt->close();
$conn->close();

// Make sure the orderDetails is not empty
if (empty($orderDetails)) {
    die("No order details found for the given order and item.");
}
?>
