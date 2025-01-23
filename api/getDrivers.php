<?php
include 'db.php';

function getDateOnly($datetime) {
    // Use PHP's date and strtotime functions to extract the date
    return date('Y-m-d', strtotime($datetime));
}


// Query to fetch driver details
$driverDataQuery = "SELECT userId AS driver_id, name, vehicleNo, created_at AS registered_on, phone AS tele_num, email FROM driverdetails";
$date = getDateOnly(date('Y-m-d H:i:s'));
$driverDataResult = mysqli_query($conn, $driverDataQuery);



if (!$driverDataResult) {
    die("Error fetching driver data: " . mysqli_error($conn));
}

// Fetch all rows into an array
$driverData = [];
while ($row = mysqli_fetch_assoc($driverDataResult)) {
    // Use getDateOnly to format the 'created_at' field as 'registered_on'
    $row['registered_on'] = getDateOnly($row['registered_on']);
    unset($row['created_at']); // Optional: Remove 'created_at' if not needed
    $driverData[] = $row;
}

?>