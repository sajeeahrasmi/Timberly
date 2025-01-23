<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $materialType = $_POST['material_type'];
    $productCategory = $_POST['product_category'];
    $unitPrice = $_POST['unit_price'];
    $description = $_POST['description'];
    
    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $imageTmpName = $_FILES['product_image']['tmp_name'];
        $imageName = basename($_FILES['product_image']['name']);
        $imagePath = 'uploads/' . $imageName;

        // Move uploaded file to the 'uploads' directory
        if (!move_uploaded_file($imageTmpName, '../api/' . $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'Error uploading image.']);
            exit;
        }
    }
    
    if (empty($materialType) || empty($productCategory) || empty($unitPrice) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $query = "INSERT INTO products (type, price, description, categories, image_path) 
              VALUES ('$materialType', '$unitPrice', '$description', '$productCategory', '$imagePath')";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Product created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating product: ' . mysqli_error($conn)]);
    }
}
?>
