<?php
include 'db.php'; // your database connection

$response = ['hasPending' => false];

// Query 1: Pending Lumber
$lumber = $conn->query("SELECT id FROM pendinglumber WHERE status = 'Pending' LIMIT 1");

// Query 2: Pending Tibre
$tibre = $conn->query("SELECT id FROM pendingtimber WHERE status = 'Pending' LIMIT 1");

// Query 3: Unapproved Suppliers
$suppliers = $conn->query("SELECT userId FROM user WHERE role = 'supplier' AND status = 'Not Approved' LIMIT 1");

// If any of them return rows, set hasPending = true
if ($lumber->num_rows > 0 || $tibre->num_rows > 0 || $suppliers->num_rows > 0) {
    $response['hasPending'] = true;
}

echo json_encode($response);
?>
