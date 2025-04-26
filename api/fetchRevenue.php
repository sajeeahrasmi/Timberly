<?php
require_once 'db.php'; 

header('Content-Type: application/json');


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
