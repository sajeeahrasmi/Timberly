<?php

include 'db.php'; 


$input = file_get_contents('php://input');
$data = json_decode($input, true);


if (isset($data['id'])) {
    
    $timberId = intval($data['id']);
    
    
    $stmt = $conn->prepare("DELETE FROM timber WHERE timberId = ?");
    $stmt->bind_param("i", $timberId);

    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete timber.']);
    }

    
    $stmt->close();
} else {
    
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}


$conn->close();
?>
