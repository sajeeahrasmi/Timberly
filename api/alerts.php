<?php

include 'db.php';


$sql = "SELECT * FROM stock_alerts ORDER BY alert_time DESC LIMIT 1"; 
$result = $conn->query($sql);


$alerts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $alerts[] = $row; 
    }
}


echo json_encode($alerts);

$conn->close();
?>
