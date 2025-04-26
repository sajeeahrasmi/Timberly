<?php
include 'db.php';

function getDateOnly($datetime) {
    return date('Y-m-d', strtotime($datetime));
}


$driverDataQuery = "SELECT userId AS driver_id, name, vehicleNo, created_at AS registered_on, phone AS tele_num, email FROM driverdetails";
$date = getDateOnly(date('Y-m-d H:i:s'));
$driverDataResult = mysqli_query($conn, $driverDataQuery);



if (!$driverDataResult) {
    die("Error fetching driver data: " . mysqli_error($conn));
}

$driverData = [];
while ($row = mysqli_fetch_assoc($driverDataResult)) {
    $row['registered_on'] = getDateOnly($row['registered_on']);
    unset($row['created_at']); // Remove 'created_at' if not needed
    $driverData[] = $row;
}

?>