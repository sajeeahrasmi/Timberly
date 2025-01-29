<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';
if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Validate the ID (e.g., ensure it's numeric or within expected format)
    if (!is_numeric($orderId)) {
        die("Invalid order ID.");
    }
}

// Include database connection
require_once '../../api/db.php';

// Fetch values from the orderfurniture and orders table
$orderId = $_GET['id'] ?? null; // Assuming you pass orderId via GET

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
            u.name , 
            u.email , 
            u.phone ,
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

    // Fetch result as associative array
    $orderDetails = $result->fetch_assoc();

    $stmt->close();
} else {
    $orderDetails = null; // No order ID provided
}

// Debug: Print order details (optional)

?>
