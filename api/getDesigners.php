<?php
include 'db.php';

function getDateOnly($datetime) {
    // Use PHP's date and strtotime functions to extract the date
    return date('Y-m-d', strtotime($datetime));
}


// Query to fetch designer details
$designerDataQuery = "SELECT userId AS designer_id, name, created_at AS registered_on, phone AS tele_num, email FROM designerdetails";
$date = getDateOnly(date('Y-m-d H:i:s'));
$designerDataResult = mysqli_query($conn, $designerDataQuery);



if (!$designerDataResult) {
    die("Error fetching designer data: " . mysqli_error($conn));
}

// Fetch all rows into an array
$designerData = [];
while ($row = mysqli_fetch_assoc($designerDataResult)) {
    // Use getDateOnly to format the 'created_at' field as 'registered_on'
    $row['registered_on'] = getDateOnly($row['registered_on']);
    unset($row['created_at']); // Optional: Remove 'created_at' if not needed
    $designerData[] = $row;
}

?>