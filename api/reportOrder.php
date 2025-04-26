<?php
header('Content-Type: application/json');


include 'db.php';


$sql = "SELECT 
            o.orderId, 
            u.name AS customer, 
            o.totalAmount AS total, 
            o.status, 
            o.date AS date 
        FROM orders o
        INNER JOIN user u ON o.userId = u.userId
        WHERE o.status = 'Completed'
        ORDER BY o.date DESC";

$result = $conn->query($sql);

$orders = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$conn->close();

echo json_encode($orders);
?>
