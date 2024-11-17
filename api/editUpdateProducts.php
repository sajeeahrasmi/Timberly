<?php
header('Content-Type: application/json');

try {
    require_once 'db.php'; 

    
    $category = $_POST['category'] ?? '';
    $productName = $_POST['productName'] ?? '';

    
    $response = ['success' => false, 'message' => 'Product update failed!'];

    
    switch ($category) {
        case 'rtimber':
            $sql = "UPDATE timber SET 
                    diameter = ?, 
                    price = ? 
                    WHERE timberId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ddi", 
                $_POST['diameter'],
                $_POST['price'],
                $productName 
            );
            break;
            
        case 'rlumber':
            $sql = "UPDATE lumber SET 
                    length = ?, 
                    width = ?,
                    thickness = ?,
                    qty = ?,
                    unitPrice = ?
                    WHERE lumberId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("dddiid", 
                $_POST['length'],
                $_POST['width'],
                $_POST['thickness'],
                $_POST['quantity'],
                $_POST['unitPrice'],
                $productName 
            );
            break;
            
        case 'ffurniture':
        
            $sql = "UPDATE products SET 
                    type = ?,
                    price = ?,
                    description = ? 
                    WHERE productId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdss",
                $_POST['type'],
                $_POST['price'],
                $_POST['description'],
                $productName 
            );
            break;
        case 'ddoorsandwindows': 
            $sql = "UPDATE products SET 
            type = ?,
            price = ?,
            description = ? 
            WHERE productId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdss",
            $_POST['type'],
            $_POST['price'],
            $_POST['description'],
            $productName 
            );
            break;
        default:
            throw new Exception('Invalid category');
    }

    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Product updated successfully!';
    } else {
        throw new Exception('Failed to update product');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}


echo json_encode($response);
?>
