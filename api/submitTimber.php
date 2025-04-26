<?php
include 'db.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $material_type = $_POST['material_type'];
    $diameter = $_POST['diameter'];
    $unit_price = $_POST['unit_price'];
    $supplierId = $_POST['supplierId'];
    $quantity = $_POST['quantity'];
    $length = $_POST['length'];

    
    if (empty($material_type) || empty($diameter) || empty($unit_price) || empty($supplierId)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';  
        $fileName = basename($_FILES['image']['name']);
        $fileTmpName = $_FILES['image']['tmp_name'];
        $filePath = $uploadDir . $fileName;  

        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            exit;
        }

        
        if (move_uploaded_file($fileTmpName, $filePath)) {
           
            $query = "INSERT INTO timber (type, price, length ,diameter, supplierId, image_path , qty) 
                      VALUES ('$material_type', '$unit_price', '$length','$diameter', '$supplierId', '$filePath' , '$quantity')";
            
            if (mysqli_query($conn, $query)) {
                echo json_encode(['success' => true, 'message' => 'Product created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error creating product: ' . mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Image is required.']);
        exit;
    }
}
?>
