
<?php

include 'db.php';

$sql = "SELECT * FROM measurement_log ORDER BY changed_at DESC LIMIT 1";
$result = $conn->query($sql);

// Check if there’s a new change
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    echo json_encode(['dateChanged' => 'yes', 'orderId' => $row['orderId']]);
} else {
    echo json_encode(['dateChanged' => 'no']);
}

$conn->close();
?>
