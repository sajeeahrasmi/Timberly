<?php
session_start(); // Start the session to access session variables
// Database connection
include '../../config/db_connection.php';

// Check if supplier is logged in
if (!isset($_SESSION['userId'])) {
    echo "Error: Supplier not logged in.";
    exit();
}

// Supplier ID and other parameters
$supplierId = $_SESSION['userId'];
$postdate = date("Y-m-d");
$is_approved = '1'; // Approved orders (1 means approved)



// Initialize an empty array to hold orders
$orders = [];

// For Timber table:
$sql1 = "SELECT id, category, type, quantity, postdate FROM pendingtimber WHERE supplierId = ? AND is_approved = '1'";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('i', $supplierId);
$stmt1->execute();
$result1 = $stmt1->get_result();
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $orders[] = [
            'id' => $row['id'],
            'category' => $row['category'],
            'type' => $row['type'],
            'quantity' => $row['quantity'],
            'postdate' => $row['postdate']
        ];
    }
}

// For Lumber table:
$sql2 = "SELECT id, type, quantity, postdate FROM pendinglumber WHERE supplierId = ? AND is_approved = '1'";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i', $supplierId);
$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $orders[] = [
            'id' => $row['id'],
            'category' => 'Lumber',
            'type' => $row['type'],
            'quantity' => $row['quantity'],
            'postdate' => $row['postdate']
        ];
    }
}



?>
