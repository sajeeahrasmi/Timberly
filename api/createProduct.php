<?php

include 'db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $materialType = $_POST['material_type'];
    $productCategory = $_POST['product_category'];
    $unitPrice = $_POST['unit_price'];
    $description = $_POST['description'];
    //$image = $_POST['product_image'];
    $size = $_POST['size'];
    $additionalDetails = $_POST['additional_details'];
    
   
$image = '';

if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
    $imageTmpName = $_FILES['product_image']['tmp_name'];
    $imageName = basename($_FILES['product_image']['name']);

    
    $destinationPath = '../public/images/' . $imageName; 

  
    $image = '../images/' . $imageName;

    
    if (!move_uploaded_file($imageTmpName, $destinationPath)) {
        echo json_encode(['success' => false, 'message' => 'Error uploading image.']);
        exit;
    }
}

    
    if (empty($materialType) || empty($productCategory) || empty($unitPrice) || empty($description) ||  empty($image) || empty($size) || empty($additionalDetails)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $query = "INSERT INTO furnitures (type, unitPrice, description, category, image, size , additionalDetails) 
          VALUES ('$materialType', '$unitPrice', '$description', '$productCategory', '$image', '$size' , '$additionalDetails')";

    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Product created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating product: ' . mysqli_error($conn)]);
    }
}
?>
