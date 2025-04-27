<?php
include '../config/db_connection.php';

session_start();

header('Content-Type: application/json');

$userId = $_SESSION['userId'] ?? null;

if (!$userId || $_SESSION['role'] !== 'supplier') {
    echo json_encode(['approved' => false, 'posts' => []]);
    exit();
}

$lumberQuery = "SELECT id FROM pendinglumber WHERE supplierId = '$userId' AND status = 'Approved'";
$timberQuery = "SELECT id FROM pendingtimber WHERE supplierId = '$userId' AND status = 'Approved'";

$lumberResult = mysqli_query($conn, $lumberQuery);
$timberResult = mysqli_query($conn, $timberQuery);

$posts = [];

while ($row = mysqli_fetch_assoc($lumberResult)) {
    $posts[] = ['postId' => $row['id'], 'type' => 'Lumber'];
}
while ($row = mysqli_fetch_assoc($timberResult)) {
    $posts[] = ['postId' => $row['id'], 'type' => 'Timber'];
}

$hasApproval = count($posts) > 0;

echo json_encode(['approved' => $hasApproval, 'posts' => $posts]);
?>
