<?php
// At the very top of deleteLumberInventory.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
header('Content-Type: application/json');

try {
    // Log the incoming data
    file_put_contents('debug.log', "Incoming data: " . file_get_contents('php://input') . "\n", FILE_APPEND);
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Log the decoded data
    file_put_contents('debug.log', "Decoded data: " . print_r($data, true) . "\n", FILE_APPEND);
    
    if (!isset($data['id'])) {
        throw new Exception('ID is required');
    }
    
    $itemId = intval($data['id']);
    
    // Log the query we're about to execute
    file_put_contents('debug.log', "Attempting to delete lumber with ID: $itemId\n", FILE_APPEND);
    
    $query = "UPDATE  lumber SET is_deleted = '1' WHERE lumberid = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $itemId);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Item deleted successfully!'
                ]);
            } else {
                throw new Exception('Item not found or could not be deleted.');
            }
        } else {
            throw new Exception('Failed to execute delete query: ' . $conn->error);
        }
        
        $stmt->close();
    } else {
        throw new Exception('Failed to prepare delete statement: ' . $conn->error);
    }
    
    $conn->close();
    
} catch (Exception $e) {
    // Log the error
    file_put_contents('debug.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>