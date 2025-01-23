<?php
include 'db.php';  // Assuming you have a database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $material_type = $_POST['material_type'];
    $diameter = $_POST['diameter'];
    $unit_price = $_POST['unit_price'];
    $supplierId = $_POST['supplierId'];

    // Check if fields are filled
    if (empty($material_type) || empty($diameter) || empty($unit_price) || empty($supplierId)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';  // Directory to save the image
        $fileName = basename($_FILES['image']['name']);
        $fileTmpName = $_FILES['image']['tmp_name'];
        $filePath = $uploadDir . $fileName;  // Unique file path

        // Validate file type (only allow images)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            exit;
        }

        // Move file to the uploads folder
        if (move_uploaded_file($fileTmpName, $filePath)) {
            // Save product data to the database
            $query = "INSERT INTO timber (type, price, diameter, supplierId, image_path) 
                      VALUES ('$material_type', '$unit_price', '$diameter', '$supplierId', '$filePath')";
            
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
