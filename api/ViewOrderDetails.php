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
            l.image_path AS imagePath,
            NULL AS description,
            NULL AS size,
            NULL AS additionalDetails,
            'lumber' AS orderType
        FROM orderlumber ol
        LEFT JOIN orders o ON ol.orderId = o.orderId
        LEFT JOIN user u ON o.userId = u.userId
        LEFT JOIN lumber l ON ol.itemId = l.lumberId
        WHERE o.orderId = ? AND ol.itemId = ?";
} else if ($type === 'furniture') {
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
            f.image AS imagePath,
            orf.type,
            orf.unitPrice,
            orf.description,
            orf.size,
            orf.additionalDetails,
            'furniture' AS orderType
        FROM orderfurniture orf
        LEFT JOIN orders o ON orf.orderId = o.orderId
        LEFT JOIN user u ON o.userId = u.userId
        LEFT JOIN furnitures f ON orf.itemId = f.furnitureId
        WHERE o.orderId = ? AND orf.itemId = ?";
}
else{
    $sql = "
        SELECT 
            o.orderId, 
            o.date, 
            o.totalAmount, 
            o.status AS orderStatus,
            ocf.itemId, 
            u.name AS customerName, 
            u.email,
            u.address,
            u.phone,
            ocf.qty, 
            ocf.status AS itemStatus, 
            CONCAT(ocf.type, ' ', ocf.length, 'x', ocf.width, 'x', ocf.thickness, ' (', ocf.qty, ') ', ocf.category) AS typeQty,
            ocf.type,
            ocf.unitPrice,
            ocf.frame,
            ocf.image AS imagePath,
            ocf.details AS description,
            CONCAT(ocf.length, 'x', ocf.width, 'x', ocf.thickness) AS size,
            NULL AS additionalDetails,
            'customized' AS orderType
        FROM ordercustomizedfurniture ocf
        LEFT JOIN orders o ON ocf.orderId = o.orderId
        LEFT JOIN user u ON o.userId = u.userId
        WHERE o.orderId = ? AND ocf.itemId = ?";
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