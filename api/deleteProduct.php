<?php


include 'db.php';


header('Content-Type: application/json');


$response = array(
    'success' => false,
    'message' => 'An error occurred.'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    
    $productId = intval($_POST['productId']); 

    
    $query = "DELETE FROM products WHERE productId = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $productId); 

        if ($stmt->execute()) {
          
            if ($stmt->affected_rows > 0) {
               
                $response['success'] = true;
                $response['message'] = 'Product deleted successfully!';
            } else {
                
                $response['message'] = 'Product not found or could not be deleted.';
            }
        } else {
            
            $response['message'] = 'Failed to execute delete query.';
        }

        $stmt->close(); 
    } else {
        
        $response['message'] = 'Failed to prepare delete statement.';
    }

    $conn->close(); 
} else {
    
    $response['message'] = 'Invalid request.';
}


echo json_encode($response);
?>