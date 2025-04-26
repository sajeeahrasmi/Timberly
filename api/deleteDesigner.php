<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['designer_id'])) {
        $designer_id = $_POST['designer_id'];
        
        $designer_id = mysqli_real_escape_string($conn, $designer_id);

        $query = "
            DELETE FROM user WHERE userId = '$designer_id';
        ";

        if (mysqli_multi_query($conn, $query)) {

            echo json_encode(['success' => true, 'message' => 'Designer deleted successfully.']);
        } else {
            
            echo json_encode(['success' => false, 'message' => 'Error deleting designer: ' . mysqli_error($conn)]);
        }
    } else {
        // Designer ID is missing
        echo json_encode(['success' => false, 'message' => 'Designer ID is required.']);
    }
}
?>
