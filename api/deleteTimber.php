<?php
// Database connection
include 'db.php'; // Ensure you have a file for database connection

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['timberId'])) {
    $timberId = intval($data['timberId']);
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