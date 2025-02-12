<?php
// Database connection (adjust with your database credentials)
include 'db.php';

// Query to fetch the latest stock alerts
$sql = "SELECT * FROM stock_alerts ORDER BY alert_time DESC LIMIT 1"; // Fetch only the latest alert
$result = $conn->query($sql);

// Initialize an array to hold the alerts
$alerts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $alerts[] = $row; // Add each alert to the array
    }
}

// Return the alerts in JSON format
echo json_encode($alerts);

$conn->close();
?>
