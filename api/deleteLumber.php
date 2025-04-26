<?php

include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = json_decode(file_get_contents('php://input'), true);
    

    
    if (isset($data['lumberId'])) {
        $lumberId = intval($data['lumberId']);

        
        $stmt = $conn->prepare("UPDATE `lumber` SET `is_deleted` = '1' WHERE `lumberId` = ?");
        $stmt->bind_param("i", $lumberId);

        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete lumber.']);
        }

        
        $stmt->close();
    } else {
        
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }

    
    $conn->close();
}
?>
