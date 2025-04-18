<?php
require 'db.php'; // your existing MySQLi connection

header('Content-Type: application/json');

$query = "SELECT COUNT(*) AS furniture_count FROM furnitures";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(['furniture_count' => $row['furniture_count']]);
} else {
    echo json_encode(['error' => mysqli_error($conn)]);
}
?>
