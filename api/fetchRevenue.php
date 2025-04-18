<?php
require_once 'db.php'; // your DB connection

header('Content-Type: application/json');

// Calculate total revenue from completed orders
$query = "SELECT SUM(totalAmount) AS revenue FROM orders WHERE status = 'Completed'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $revenue = $row['revenue'] ?? 0;
    echo json_encode(['revenue' => $revenue]);
} else {
    echo json_encode(['revenue' => 0]);
}
?>
