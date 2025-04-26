<?php
include 'db.php';

function getDateOnly($datetime) {
    return date('Y-m-d', strtotime($datetime));
}


$customerDataQuery = "SELECT userId AS customer_id, name, created_at AS registered_on, phone AS tele_num, email FROM user WHERE role = 'customer'";
$date = getDateOnly(date('Y-m-d H:i:s'));
$customerDataResult = mysqli_query($conn, $customerDataQuery);



if (!$customerDataResult) {
    die("Error fetching customer data: " . mysqli_error($conn));
}

$customerData = [];
while ($row = mysqli_fetch_assoc($customerDataResult)) {
    $row['registered_on'] = getDateOnly($row['registered_on']);
    unset($row['created_at']); // Remove 'created_at' if not needed
    $customerData[] = $row;
}

?>