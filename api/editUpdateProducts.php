<?php
// update-product.php
include 'db.php';

$productId = $_POST['productId'];
$category = $_POST['category'];
$response = ['success' => false, 'message' => 'Product update failed!'];

if ($category == 'raw-materials') {
    $type = $_POST['type'];
    $diameter = $_POST['diameter'];
    $price = $_POST['price'];
    $supplierId = $_POST['supplierId'];

    $query = "UPDATE timber SET type = ?, diameter = ?, price = ?, supplierId = ? WHERE timberId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sdiii', $type, $diameter, $price, $supplierId, $productId);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Product updated successfully!'];
    }
} elseif ($category == 'furniture' || $category == 'doors-and-windows') {
    $description = $_POST['description'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $review = $_POST['review'];

    $query = "UPDATE products SET description = ?, type = ?, price = ?, review = ? WHERE productId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssdsi', $description, $type, $price, $review, $productId);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Product updated successfully!'];
    }
}

echo json_encode($response);
?>
