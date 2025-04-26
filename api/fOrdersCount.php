<?php
require 'db.php'; 

header('Content-Type: application/json');

$query = "SELECT COUNT(*) AS order_count FROM orders";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(['order_count' => $row['order_count']]);
} else {
    echo json_encode(['error' => mysqli_error($conn)]);
}
?>
