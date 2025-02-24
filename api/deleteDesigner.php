<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the designer from the POST data
    if (isset($_POST['designer_id'])) {
        $designer_id = $_POST['designer_id'];
        
        // Sanitize designer_id to prevent SQL injection
        $designer_id = mysqli_real_escape_string($conn, $designer_id);

        // Query to delete designer from both the user and designer tables
        $query = "
            DELETE FROM user WHERE userId = '$designer_id';
        ";

        // Execute the query
        if (mysqli_multi_query($conn, $query)) {
            // Success
            echo json_encode(['success' => true, 'message' => 'Designer deleted successfully.']);
        } else {
            // Failure
            echo json_encode(['success' => false, 'message' => 'Error deleting designer: ' . mysqli_error($conn)]);
        }
    } else {
        // Designer ID is missing
        echo json_encode(['success' => false, 'message' => 'Designer ID is required.']);
    }
}
?>
