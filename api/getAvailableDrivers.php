<?php
require_once 'db.php';

$sql = "SELECT driverId, vehicleNo FROM driver WHERE available = 'YES'";
$result = $conn->query($sql);

$drivers = [];
while ($row = $result->fetch_assoc()) {
    $drivers[] = $row;
}

echo json_encode($drivers);
$conn->close();
?>
