<?php
include 'db.php';

function getDateOnly($datetime) {
    // Use PHP's date and strtotime functions to extract the date
    return date('Y-m-d', strtotime($datetime));
}


// Query to fetch customer details
$customerDataQuery = "SELECT userId AS customer_id, name, created_at AS registered_on, phone AS tele_num, email FROM user WHERE role = 'customer'";
$date = getDateOnly(date('Y-m-d H:i:s'));
$customerDataResult = mysqli_query($conn, $customerDataQuery);



if (!$customerDataResult) {
    die("Error fetching customer data: " . mysqli_error($conn));
}

// Fetch all rows into an array
$customerData = [];
while ($row = mysqli_fetch_assoc($customerDataResult)) {
    // Use getDateOnly to format the 'created_at' field as 'registered_on'
    $row['registered_on'] = getDateOnly($row['registered_on']);
    unset($row['created_at']); // Optional: Remove 'created_at' if not needed
    $customerData[] = $row;
}

?>