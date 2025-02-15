<?php
header('Content-Type: application/json');

include 'db.php';

$sql = "SELECT 
    o.orderId, 
    o.date, 
    o.itemQty,
    o.totalAmount, 
    o.status AS orderStatus, 
    u.name AS customerName, 
    o.userId AS customerId,
    ol.orderId,  
    ol.itemId, 
    ol.qty,  
    ol.status AS itemStatus,
    l.type  -- Fetch the 'type' from the lumber table
FROM orderlumber ol
LEFT JOIN orders o ON ol.orderId = o.orderId  
LEFT JOIN user u ON o.userId = u.userId
LEFT JOIN lumber l ON ol.itemId = l.lumberId";  // Join with lumber table

$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Directly push the row into the $orders array
        $orders[] = $row;
    }
}

// Send JSON response
echo json_encode($orders);

$conn->close();
?>
