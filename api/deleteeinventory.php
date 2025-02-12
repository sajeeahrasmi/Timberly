<?php
// Authentication check - Ensure the user is authenticated before proceeding
require_once '../../api/auth.php';

// Include the necessary files for database connection or inventory management
require_once '../../api/database.php'; // Example, replace with your actual database connection

// Get the raw POST data from the request
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);

// Check if 'id' and 'type' are provided
if (isset($data['id']) && isset($data['type'])) {
    $id = $data['id'];
    $type = $data['type'];

    // Check the type and delete the appropriate inventory item
    if ($type === 'timber') {
        // Example query to delete timber item by ID
        $query = "DELETE FROM timber_inventory WHERE id = ?";
    } elseif ($type === 'lumber') {
        // Example query to delete lumber item by ID
        $query = "DELETE FROM lumber_inventory WHERE id = ?";
    } else {
        // Invalid type
        echo json_encode(['success' => false, 'message' => 'Invalid material type']);
        exit;
    }

    // Prepare and execute the query
    try {
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        // Check if the deletion was successful
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not found or already deleted']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Missing id or type
    echo json_encode(['success' => false, 'message' => 'Missing id or type']);
}
?>
