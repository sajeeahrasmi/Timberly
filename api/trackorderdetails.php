<?php
// Trackorder.php

// Include database connection
include 'db.php';

// Get the order ID from the URL
$orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($orderId) {
    // Query to fetch order, customer, and user details
    $query = "
        SELECT 
            o.orderId, 
            o.date, 
            oi.status, 
            oi.unitPrice, 
            oi.qty, 
            (oi.unitPrice * oi.qty) AS totalAmount,
            oi.size,
            oi.description,
            u.userId, 
            u.name, 
            u.email, 
            u.phone, 
            u.address 
        FROM orderfurniture oi
        LEFT JOIN orders o ON oi.orderId = o.orderId
        LEFT JOIN user u ON o.userId = u.userId
        WHERE o.orderId = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all results as an array (since an order may have multiple items)
    $orderDetails = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();
} else {
    $orderDetails = []; // Initialize as empty array
}

// Debugging (optional)
// echo "<pre>"; print_r($orderDetails); echo "</pre>";

?>
