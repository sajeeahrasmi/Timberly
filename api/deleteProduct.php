<?php
header('Content-Type: application/json');

// Database connection
require_once 'db.php';

$response = ['success' => false, 'message' => 'Product deletion failed!'];

try {
    // Get productId from POST request
    $productId = $_POST['productId'] ?? null;

    if ($productId) {
        // Determine which table to delete the product from based on category
        $sql = "DELETE FROM furnitures WHERE furnitureId = ?";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }

        // Bind the productId to the prepared statement
        $stmt->bind_param("i", $productId);
        
        // Execute the delete query
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = 'Product deleted successfully!';
        } else {
            $response['message'] = 'No product found with the given ID or the product has already been deleted.';
        }
    } else {
        $response['message'] = 'Invalid product ID.';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
