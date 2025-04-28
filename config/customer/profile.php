<?php

include_once '../../config/db_connection.php';


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'updateProfile':
            updateProfile();
            break;
        
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}


function updateProfile() {
    global $conn;

    $userId = $_GET['userId'] ?? null;
    $email = $_GET['email'] ?? null;
    $address = $_GET['address'] ?? null;
    $phone = $_GET['phone'] ?? null;
   

    $updateQuery = "UPDATE user SET email = ?, address = ?, phone = ?  WHERE userId = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("sssi", $email, $address, $phone, $userId);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
    }
}
//finalgit 

?>
