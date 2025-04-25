<?php

include 'db.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

$driver_id = $_GET['driver_id'] ?? '';
if (!$driver_id) {
    die("Driver ID not provided.");
}

// Get driver info with time difference
$query = "SELECT *, TIMESTAMPDIFF(SECOND, created_at, NOW()) AS seconds_elapsed 
          FROM driverdetails WHERE userId = '$driver_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching driver data: " . mysqli_error($conn));
}
$driver = mysqli_fetch_assoc($result);

if (!$driver) {
    die("Driver with ID $driver_id not found.");
}
// Get deliveries from all order tables
$query1 = "
 SELECT orderId, date, unitPrice, driverId FROM orderfurniture
 WHERE driverId = '$driver_id' AND status = 'Delivered' AND date IS NOT NULL AND date != '0000-00-00'
 UNION ALL
 SELECT orderId, date, unitPrice, driverId FROM ordercustomizedfurniture
 WHERE driverId = '$driver_id' AND status = 'Delivered' AND date IS NOT NULL AND date != '0000-00-00'
 UNION ALL
 SELECT orderId, date, NULL AS unitPrice, driverId FROM orderlumber
 WHERE driverId = '$driver_id' AND status = 'Delivered' AND date IS NOT NULL AND date != '0000-00-00'
 ORDER BY date DESC
";

$result1 = mysqli_query($conn, $query1);
if (!$result1) {
    die("Error fetching order data: " . mysqli_error($conn));
}

$deliveryData = [];
while ($row = mysqli_fetch_assoc($result1)) {
    $deliveryData[] = $row;
}

// Convert registration time into human-readable "time ago"
$seconds_elapsed = $driver['seconds_elapsed'];
$time_ago = formatTimeAgo($seconds_elapsed);

function formatTimeAgo($seconds) {
    if ($seconds < 60) {
        return $seconds == 1 ? "1 second ago" : "$seconds seconds ago";
    } elseif ($seconds < 3600) {
        $minutes = floor($seconds / 60);
        return $minutes == 1 ? "1 minute ago" : "$minutes minutes ago";
    } elseif ($seconds < 86400) {
        $hours = floor($seconds / 3600);
        return $hours == 1 ? "1 hour ago" : "$hours hours ago";
    } elseif ($seconds < 2592000) {
        $days = floor($seconds / 86400);
        return $days == 1 ? "1 day ago" : "$days days ago";
    } elseif ($seconds < 31536000) {
        $months = floor($seconds / 2592000);
        return $months == 1 ? "1 month ago" : "$months months ago";
    } else {
        $years = floor($seconds / 31536000);
        return $years == 1 ? "1 year ago" : "$years years ago";
    }
}
?>