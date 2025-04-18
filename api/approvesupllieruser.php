<?php
include 'db.php';

// Get JSON input instead of POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Debug - log the received data
error_log("Received data: " . print_r($data, true));

$userId = $data['userId'] ?? null;
$status = $data['status'] ?? null;

// Debug - log the extracted values
error_log("userId: $userId, status: $status");

if ($userId && $status) {
    // Update the user status in the database
    $query = "UPDATE user SET status = ? WHERE userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $userId);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'User status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update user status. Query executed but no rows affected.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input. userId or status is missing.']);
}

// Close connection
$conn->close();
?>