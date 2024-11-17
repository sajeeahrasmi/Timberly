<?php

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $materialType = $_POST['material_type'];
    $productCategory = $_POST['product_category'];
    $unitPrice = $_POST['unit_price'];
    $description = $_POST['description'];

    
    if (empty($materialType) || empty($productCategory) || empty($unitPrice) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    $query = "INSERT INTO products (type, price, description, categories) 
              VALUES ('$materialType', '$unitPrice', '$description', '$productCategory')";

    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Product created successfully']);
    } else {
        
        echo json_encode(['success' => false, 'message' => 'Error creating product: ' . mysqli_error($conn)]);
    }
}
?>
