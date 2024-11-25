<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the driver_id from the POST data
    if (isset($_POST['driver_id'])) {
        $driver_id = $_POST['driver_id'];
        
        // Sanitize driver_id to prevent SQL injection
        $driver_id = mysqli_real_escape_string($conn, $driver_id);

        // Query to delete driver from both the user and driver tables
        $query = "
            DELETE FROM user WHERE userId = '$driver_id';
            DELETE FROM driver WHERE driverId = '$driver_id';
        ";

        // Execute the query
        if (mysqli_multi_query($conn, $query)) {
            // Success
            echo json_encode(['success' => true, 'message' => 'Driver deleted successfully.']);
        } else {
            // Failure
            echo json_encode(['success' => false, 'message' => 'Error deleting driver: ' . mysqli_error($conn)]);
        }
    } else {
        // Driver ID is missing
        echo json_encode(['success' => false, 'message' => 'Driver ID is required.']);
    }
}
?>
