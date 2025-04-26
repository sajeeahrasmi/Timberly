<?php
require_once 'db.php';

$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
$itemId = isset($_GET['itemId']) ? $_GET['itemId'] : '';

$orderDetails = [];


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
        m.name AS measurerName,
        m.contact AS measurerContact,
        m.date AS measurementDate,
        m.time AS measurementTime,
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
    LEFT JOIN measurement m ON m.orderId = ol.orderId 
    WHERE o.orderId = ? AND ol.itemId = ?";

$stmt = $conn->prepare($sqlLumber);
$stmt->bind_param("ii", $orderId, $itemId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orderDetails[] = $row;
}
$stmt->close();


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
        mf.name AS measurerName,
        mf.contact AS measurerContact,
        mf.date AS measurementDate,
        mf.time AS measurementTime,
        `of`.qty, 
       
        `of`.status AS itemStatus, 
        `of`.unitPrice,
        `of`.driverId,
        CONCAT(`of`.description, ' - ', `of`.type, ' ', `of`.size, ' | ', `of`.additionalDetails) AS typeQty,

        'furniture' AS orderType
    FROM orderfurniture `of`
    LEFT JOIN orders o ON `of`.orderId = o.orderId
    LEFT JOIN user u ON o.userId = u.userId
    LEFT JOIN measurement mf ON mf.orderId = `of`.orderId 
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
        mc.name AS measurerName,
        mc.contact AS measurerContact,
        mc.date AS measurementDate,
        mc.time AS measurementTime,
        oc.qty, 
        oc.driverId,
       
        oc.status AS itemStatus, 
        oc.unitPrice,
        CONCAT(oc.type, ' - ', oc.category,' - ', oc.length, ' x ', oc.width, ' x ', oc.thickness) AS typeQty,
        'customized' AS orderType
    FROM ordercustomizedfurniture oc
    LEFT JOIN orders o ON oc.orderId = o.orderId
    LEFT JOIN measurement m ON m.orderId = oc.orderId 
    LEFT JOIN user u ON o.userId = u.userId
    LEFT JOIN measurement mc ON mc.orderId = oc.orderId 
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


if (empty($orderDetails)) {
    die("No order details found for the given order and item.");
}



?>
