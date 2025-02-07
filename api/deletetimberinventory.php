<?php
// Include the database connection file
include 'db.php'; // Ensure this file contains the correct database connection code

// Get JSON input from the request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if 'timberId' is provided in the input
if (isset($data['id'])) {
    // Get the timberId and sanitize it
    $timberId = intval($data['id']);
    
    // Prepare the SQL statement to delete the timber record
    $stmt = $conn->prepare("DELETE FROM timber WHERE timberId = ?");
    $stmt->bind_param("i", $timberId);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete timber.']);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // If 'timberId' is not provided in the input, return an error
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

// Close the database connection
$conn->close();
?>
