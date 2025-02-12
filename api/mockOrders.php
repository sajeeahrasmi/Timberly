<?php
header('Content-Type: application/json');

include 'db.php';


$sql = "SELECT 
o.orderId, 
o.date, 
o.totalAmount, 
o.status AS orderStatus, 
u.name AS customerName, 
o.userId AS customerId,  
oi.itemId, 
oi.description, 
oi.qty, 
oi.size, 
oi.unitPrice, 
oi.status AS itemStatus
FROM orderfurniture oi
LEFT JOIN orders o ON oi.orderId = o.orderId  
LEFT JOIN user u ON o.userId = u.userId"; 
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['orderId'];
        $orders[$order_id] = $row;
        
    }
}



// Send JSON response
echo json_encode(array_values($orders));

$conn->close();
?>
