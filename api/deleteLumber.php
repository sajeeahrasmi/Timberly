<?php
// api/deleteLumber.php
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if 'lumberId' is present in the received data
    if (isset($data['id'])) {
        $lumberId = intval($data['id']);

        // Prepare the query for soft delete (set is_deleted = 1)
        $stmt = $conn->prepare("UPDATE `lumber` SET `is_deleted` = 1 WHERE `lumberId` = ?");
        $stmt->bind_param("i", $lumberId);

        // Execute the query and return the result
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete lumber.']);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Return error if lumberId is not provided
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }

    // Close the database connection
    $conn->close();
}
?>
