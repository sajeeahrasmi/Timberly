<?php

include 'db.php';

$supplier_id = $_GET['supplier_id'] ?? '';

$query = "SELECT *, TIMESTAMPDIFF(SECOND, created_at, NOW()) AS seconds_elapsed 
          FROM user WHERE userId = '$supplier_id'";
$result = mysqli_query($conn, $query);
$supplier = mysqli_fetch_assoc($result);

$query1 = "(SELECT * FROM pendingtimber WHERE supplierId = '$supplier_id' ORDER BY postdate DESC)";
$result1 = mysqli_query($conn, $query1);

if (!$result1) {
    die("Error fetching order data: " . mysqli_error($conn));
}
$postData = [];
$count = 0;
while ($row = mysqli_fetch_assoc($result1)) {
    $postData[] = $row;
    $count++;
}

$lastPostTimeAgo = "No orders"; // default value

if (!empty($postData)) {
    $lastPostDate = strtotime($postData[0]['postdate']);
    $currentTime = time();
    $seconds_since_last_post = $currentTime - $lastPostDate;
    $lastPostTimeAgo = formatTimeAgo($seconds_since_last_post);
}

// Get elapsed time
$seconds_elapsed = $supplier['seconds_elapsed'];

// Convert seconds into human-readable format
$time_ago = formatTimeAgo($seconds_elapsed);

// Function to convert seconds to a human-readable time ago format
function formatTimeAgo($seconds) {
    if ($seconds < 60) {
        if ($seconds == 1) {
            return "1 second ago";
        }
        else {
            return "$seconds seconds ago";
        }
    } elseif ($seconds < 3600) {
        $minutes = floor($seconds / 60);
        if ($minutes == 1) {
            return "1 minute ago";
        }
        else {
            return "$minutes minutes ago";
        }
    } elseif ($seconds < 86400) {
        $hours = floor($seconds / 3600);
        if ($hours == 1) {
            return "1 hour ago";
        }
        else {
            return "$hours hours ago";
        }
    } elseif ($seconds < 2592000) { // Less than 30 days
        $days = floor($seconds / 86400);
        if ($days == 1) {
            return "1 day ago";
        }
        else {
            return "$days days ago";
        }
    } elseif ($seconds < 31536000) { // Less than a year
        $months = floor($seconds / 2592000); // Approx. 30 days per month
        if ($months == 1) {
            return "1 month ago";
        }
        else {
            return "$months months ago";
        }
    } else {
        $years = floor($seconds / 31536000); // Approx. 365 days per year
        if ($years == 1) {
            return "1 year ago";
        }
        else {
            return "$years years ago";
        }
    }
}
?>
