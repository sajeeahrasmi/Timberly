<?php
require_once 'db.php';

$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
$itemId = isset($_GET['itemId']) ? $_GET['itemId'] : '';

$orderDetails = [];

// Fetch from orderlumber
$sqlLumber = "
    SELECT 
        o.orderId, 
        o.date, 
        o.deliveryFee,
        o.totalAmount, 
        o.status AS orderStatus,
        ol.itemId, 
        u.name AS customerName, 
        u.email,
        u.address,
        u.phone,
        ol.qty, 
        ol.status AS itemStatus, 
        ol.driverId,
        l.unitPrice,
        CONCAT(l.type, ' (', ol.qty, ')') AS typeQty,
        'lumber' AS orderType
    FROM orderlumber ol
    LEFT JOIN orders o ON ol.orderId = o.orderId
    LEFT JOIN user u ON o.userId = u.userId
    LEFT JOIN lumber l ON ol.itemId = l.lumberId
    WHERE o.orderId = ? AND ol.itemId = ?";

$stmt = $conn->prepare($sqlLumber);
$stmt->bind_param("ii", $orderId, $itemId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orderDetails[] = $row;
}
$stmt->close();

// Fetch from orderfurniture
$sqlFurniture = "
    SELECT 
        o.orderId, 
        `of`.date, 
        o.deliveryFee,
        o.totalAmount, 
        o.status AS orderStatus,
        `of`.itemId, 
        u.name AS customerName, 
        u.email,
        u.address,
        u.phone,
        `of`.qty, 
        `of`.status AS itemStatus, 
        `of`.unitPrice,
        `of`.driverId,
        CONCAT(`of`.description, ' - ', `of`.type, ' ', `of`.size, ' | ', `of`.additionalDetails) AS typeQty,

        'furniture' AS orderType
    FROM orderfurniture `of`
    LEFT JOIN orders o ON `of`.orderId = o.orderId
    LEFT JOIN user u ON o.userId = u.userId
    WHERE o.orderId = ? AND `of`.itemId = ?";

$stmt = $conn->prepare($sqlFurniture);
$stmt->bind_param("ii", $orderId, $itemId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orderDetails[] = $row;
}
$stmt->close();
$sqlCustomized = "
    SELECT 
        o.orderId, 
        oc.date, 
        o.deliveryFee,
        o.totalAmount, 
        o.status AS orderStatus,
        oc.itemId, 
        u.name AS customerName, 
        u.email,
        u.address,
        u.phone,
        oc.qty, 
        oc.driverId,
        oc.status AS itemStatus, 
        oc.unitPrice,
        CONCAT(oc.type, ' - ', oc.category,' - ', oc.length, ' x ', oc.width, ' x ', oc.thickness) AS typeQty,
        'customized' AS orderType
    FROM ordercustomizedfurniture oc
    LEFT JOIN orders o ON oc.orderId = o.orderId
    LEFT JOIN user u ON o.userId = u.userId
    WHERE o.orderId = ? AND oc.itemId = ?";

$stmt = $conn->prepare($sqlCustomized);
$stmt->bind_param("ii", $orderId, $itemId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orderDetails[] = $row;
}
$stmt->close();
$conn->close();

// Check if there's any data
if (empty($orderDetails)) {
    die("No order details found for the given order and item.");
}

// Continue using $orderDetails...
?>
