<?php
include 'db.php';

// Get the userId from the POST request
$userId = $_POST['userId'] ?? null;

// Debug logging
error_log("Received userId for deletion: $userId");

// Check if userId is not null
if ($userId) {
    // Start a transaction to ensure data integrity
    $conn->begin_transaction();
    
    try {
        // First delete any related records (assuming there might be products or other relations)
        // For example, if there's a supplier table linked to the user table:
        
        // Then delete the user record
        $query2 = "DELETE FROM user WHERE userId = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $userId);
        $stmt2->execute();
        
        // Check if the user was deleted
        if ($stmt2->affected_rows > 0) {
            // Commit the transaction
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Supplier deleted successfully.']);
        } else {
            // Rollback if no rows were affected
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'No supplier found with this ID.']);
        }
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        error_log("Error deleting supplier: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
}

// Close the database connection
$conn->close();
?>