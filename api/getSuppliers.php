<?php
include 'db.php';

function getDateOnly($datetime) {
    // Use PHP's date and strtotime functions to extract the date
    return date('Y-m-d', strtotime($datetime));
}


// Query to fetch supplier details
$supplierDataQuery = "SELECT userId AS supplier_id, name, created_at AS registered_on, phone AS tele_num, email FROM user WHERE role = 'supplier'";
$date = getDateOnly(date('Y-m-d H:i:s'));
$supplierDataResult = mysqli_query($conn, $supplierDataQuery);



if (!$supplierDataResult) {
    die("Error fetching supplier data: " . mysqli_error($conn));
}

// Fetch all rows into an array
$supplierData = [];
while ($row = mysqli_fetch_assoc($supplierDataResult)) {
    // Use getDateOnly to format the 'created_at' field as 'registered_on'
    $row['registered_on'] = getDateOnly($row['registered_on']);
    unset($row['created_at']); // Optional: Remove 'created_at' if not needed
    $supplierData[] = $row;
}

?>