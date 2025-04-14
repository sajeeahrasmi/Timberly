<?php
// Include the database connection (assuming it's in the same directory)
require_once 'db.php';

// Get the orderId, itemId, and type from the URL
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';
$itemId = isset($_GET['itemId']) ? $_GET['itemId'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'lumber'; // Default to lumber if not specified

$orderDetails = null;

if ($type === 'lumber') {
    // Fetch the details of the specific lumber item
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
            CONCAT(l.type, ' (', ol.qty, ')') AS typeQty,
            l.type,
            NULL AS description,
            NULL AS size,
            NULL AS additionalDetails,
            'lumber' AS orderType
        FROM orderlumber ol
        LEFT JOIN orders o ON ol.orderId = o.orderId
        LEFT JOIN user u ON o.userId = u.userId
        LEFT JOIN lumber l ON ol.itemId = l.lumberId
        WHERE o.orderId = ? AND ol.itemId = ?";
} else {
    // Fetch the details of the specific furniture item
    $sql = "
        SELECT 
            o.orderId, 
            o.date, 
            o.totalAmount, 
            o.status AS orderStatus,
            orf.itemId, 
            u.name AS customerName, 
            u.email,
            u.address,
            u.phone,
            orf.qty, 
            orf.status AS itemStatus, 
            CONCAT(orf.type, ' (', orf.qty, ')') AS typeQty,
            orf.type,
            orf.description,
            orf.size,
            orf.additionalDetails,
            'furniture' AS orderType
        FROM orderfurniture orf
        LEFT JOIN orders o ON orf.orderId = o.orderId
        LEFT JOIN user u ON o.userId = u.userId
        WHERE o.orderId = ? AND orf.itemId = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $orderId, $itemId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $orderDetails = $result->fetch_assoc();
}

$stmt->close();
$conn->close();

return $orderDetails;
?>