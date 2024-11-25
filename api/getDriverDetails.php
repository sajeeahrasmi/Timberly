<?php

include 'db.php';

$driver_id = $_GET['driver_id'] ?? '';

$query = "SELECT *, TIMESTAMPDIFF(SECOND, created_at, NOW()) AS seconds_elapsed 
          FROM driverdetails WHERE userId = '$driver_id'";
$result = mysqli_query($conn, $query);
$driver = mysqli_fetch_assoc($result);

// Get elapsed time
$seconds_elapsed = $driver['seconds_elapsed'];

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
