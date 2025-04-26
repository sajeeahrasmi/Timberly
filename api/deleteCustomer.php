<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['customer_id'])) {
        $customer_id = $_POST['customer_id'];
        
        
        $customer_id = mysqli_real_escape_string($conn, $customer_id);


        $query = "
            DELETE FROM user WHERE userId = '$customer_id';
        ";

        
        if (mysqli_multi_query($conn, $query)) {
            echo json_encode(['success' => true, 'message' => 'Customer deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting customer: ' . mysqli_error($conn)]);
        }
    } else {
        // Customer ID is missing
        echo json_encode(['success' => false, 'message' => 'Customer ID is required.']);
    }
}
?>
