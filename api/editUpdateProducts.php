<?php
header('Content-Type: application/json');

try {
    require_once 'db.php';

    $category = $_POST['category'] ?? '';
    $productName = $_POST['productName'] ?? '';
    $quantity = $_POST['quantity'] ?? null;

    
    $response = ['success' => false, 'message' => 'Product update failed!'];

    
    $sql = "";
    $bindParams = [];
    $paramTypes = "";

    switch ($category) {
        case 'rtimber':
            $sql = "UPDATE timber SET length = ?, diameter = ?, price = ?, qty = ? WHERE timberId = ?";
            $bindParams = [$_POST['length'],$_POST['diameter'], $_POST['price'], $_POST['quantity'], $productName];
            $paramTypes = "dddii";
            break;

        case 'rlumber':
            $sql = "UPDATE lumber SET length = ?, width = ?, thickness = ?, qty = ?, unitPrice = ? WHERE lumberId = ?";
            $bindParams = [$_POST['length'], $_POST['width'], $_POST['thickness'], $_POST['quantity'], $_POST['unitPrice'], $productName];
            $paramTypes = "dddiid";
            break;

        case 'ffurniture':
        case 'ddoorsandwindows':
            $sql = "UPDATE furnitures SET type = ?, unitPrice = ?, description = ?, size = ? , additionalDetails = ? WHERE furnitureId = ?";
            $bindParams = [$_POST['type'], $_POST['unitPrice'], $_POST['description'], $_POST['size'], $_POST['additionalDetails'], $productName];
            $paramTypes = "sdssss";
            break;

        default:
            throw new Exception('Invalid category');
    }

    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param($paramTypes, ...$bindParams);
    $stmt->execute();

   
    if ($stmt->affected_rows > 0) {
        $response['success'] = true;
        $response['message'] = 'Product updated successfully!';
    } else {
        $response['message'] = 'No rows updated. Please check the product and try again.';
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
