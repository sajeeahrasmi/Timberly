<?php

include 'db.php';

$designer_id = $_GET['designer_id'] ?? '';

$query = "SELECT *, TIMESTAMPDIFF(SECOND, created_at, NOW()) AS seconds_elapsed 
          FROM user WHERE userId = '$designer_id'";
$result = mysqli_query($conn, $query);
$designer = mysqli_fetch_assoc($result);

$seconds_elapsed = $designer['seconds_elapsed'];

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
    } elseif ($seconds < 31536000) { 
        $months = floor($seconds / 2592000); 
        if ($months == 1) {
            return "1 month ago";
        }
        else {
            return "$months months ago";
        }
    } else {
        $years = floor($seconds / 31536000); 
        if ($years == 1) {
            return "1 year ago";
        }
        else {
            return "$years years ago";
        }
    }
}
?>
