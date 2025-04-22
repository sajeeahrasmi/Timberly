<?php
// fetchApprovedOrders.php

// Include your database connection
include '../../config/db_connection.php'; // Adjust the path as needed

// Initialize an array to hold all approved orders
$approvedOrders = [];

// Fetch approved lumber orders
$lumberQuery = "SELECT id, category, type, quantity, date FROM pendinglumber WHERE is_approved = 1";
$lumberResult = mysqli_query($conn, $lumberQuery);

if ($lumberResult) {
    while ($row = mysqli_fetch_assoc($lumberResult)) {
        $approvedOrders[] = $row;
    }
}

// Fetch approved timber orders
$timberQuery = "SELECT id, category, type, quantity, date FROM pendingtimber WHERE is_approved = 1";
$timberResult = mysqli_query($conn, $timberQuery);

if ($timberResult) {
    while ($row = mysqli_fetch_assoc($timberResult)) {
        $approvedOrders[] = $row;
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($approvedOrders);
?>
