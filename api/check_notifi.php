<?php
include 'db.php'; 

$response = ['hasPending' => false];


$lumber = $conn->query("SELECT id FROM pendinglumber WHERE status = 'Pending' LIMIT 1");


$tibre = $conn->query("SELECT id FROM pendingtimber WHERE status = 'Pending' LIMIT 1");


$suppliers = $conn->query("SELECT userId FROM user WHERE role = 'supplier' AND status = 'Not Approved' LIMIT 1");


if ($lumber->num_rows > 0 || $tibre->num_rows > 0 || $suppliers->num_rows > 0) {
    $response['hasPending'] = true;
}

echo json_encode($response);
?>
