<?php

include 'db.php';

$customer_id = $_GET['customer_id'] ?? '';

$query = "SELECT *, TIMESTAMPDIFF(SECOND, created_at, NOW()) AS seconds_elapsed 
          FROM user WHERE userId = '$customer_id'";
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_assoc($result);

$query1 = "SELECT * FROM orders WHERE userId = '$customer_id' ORDER BY date DESC";
$result1 = mysqli_query($conn, $query1);

if (!$result1) {
    die("Error fetching order data: " . mysqli_error($conn));
}
$orderData = [];
$count = 0;
while ($row = mysqli_fetch_assoc($result1)) {
    $orderData[] = $row;
    $count++;
}

$lastOrderTimeAgo = "No orders"; // default value

if (!empty($orderData)) {
    $lastOrderDate = strtotime($orderData[0]['date']);
    $currentTime = time();
    $seconds_since_last_order = $currentTime - $lastOrderDate;
    $lastOrderTimeAgo = formatTimeAgo($seconds_since_last_order);
}

$seconds_elapsed = $customer['seconds_elapsed'];

$time_ago = formatTimeAgo($seconds_elapsed);

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
    } elseif ($seconds < 2592000) {
        $days = floor($seconds / 86400);
        if ($days == 1) {
            return "1 day ago";
        }
        else {
            return "$days days ago";
        }
    } elseif ($seconds < 31536000) {
        $months = floor($seconds / 2592000);
        if ($months == 1) {
            return "1 month ago";
        }
        else {
            return "$months months ago";
        }
    } else {
        $years = floor($seconds / 31536000); // 
        if ($years == 1) {
            return "1 year ago";
        }
        else {
            return "$years years ago";
        }
    }
}
?>
