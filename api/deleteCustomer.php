<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the customer from the POST data
    if (isset($_POST['customer_id'])) {
        $customer_id = $_POST['customer_id'];
        
        // Sanitize customer_id to prevent SQL injection
        $customer_id = mysqli_real_escape_string($conn, $customer_id);

        // Query to delete customer from both the user and customer tables
        $query = "
            DELETE FROM user WHERE userId = '$customer_id';
        ";

        // Execute the query
        if (mysqli_multi_query($conn, $query)) {
            // Success
            echo json_encode(['success' => true, 'message' => 'Customer deleted successfully.']);
        } else {
            // Failure
            echo json_encode(['success' => false, 'message' => 'Error deleting customer: ' . mysqli_error($conn)]);
        }
    } else {
        // Customer ID is missing
        echo json_encode(['success' => false, 'message' => 'Customer ID is required.']);
    }
}
?>
