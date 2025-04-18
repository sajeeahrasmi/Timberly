<?php

include_once '../../config/db_connection.php';
header('Content-Type: application/json');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {    
        case 'updateview':
            updateview();
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}





function updateview(){
    global $conn;

    $notificationId = $_GET['notificationId'];

    mysqli_begin_transaction($conn);

    try {
        
        $query = "UPDATE customernotification SET view = 'yes' WHERE notificationId = ?";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("i", $notificationId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to update');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        
    }
}


?>