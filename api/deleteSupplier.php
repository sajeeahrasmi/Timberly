<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the supplier from the POST data
    if (isset($_POST['supplier_id'])) {
        $supplier_id = $_POST['supplier_id'];
        
        // Sanitize supplier_id to prevent SQL injection
        $supplier_id = mysqli_real_escape_string($conn, $supplier_id);

        // Query to delete supplier from both the user and supplier tables
        $query = "
            DELETE FROM user WHERE userId = '$supplier_id';
        ";

        // Execute the query
        if (mysqli_multi_query($conn, $query)) {
            // Success
            echo json_encode(['success' => true, 'message' => 'Supplier deleted successfully.']);
        } else {
            // Failure
            echo json_encode(['success' => false, 'message' => 'Error deleting supplier: ' . mysqli_error($conn)]);
        }
    } else {
        // Supplier ID is missing
        echo json_encode(['success' => false, 'message' => 'Supplier ID is required.']);
    }
}
?>
