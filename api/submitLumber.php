<?php

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $material_type = $_POST['material_type'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $thickness = $_POST['thickness'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    // Check required fields
    if (empty($material_type) || empty($length) || empty($unit_price) || empty($width) || empty($thickness) || empty($quantity)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Handle file upload
    $imagePath = ''; // Initialize image path variable

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory to save the image
        $fileName = basename($_FILES['image']['name']);
        $fileTmpName = $_FILES['image']['tmp_name'];
        $filePath = $uploadDir . $fileName; // Path where the file will be stored

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            exit;
        }

        // Move file to the uploads directory
        if (!move_uploaded_file($fileTmpName, $filePath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
            exit;
        }

        $imagePath = $filePath; // Store the path of the uploaded image
    } else {
        echo json_encode(['success' => false, 'message' => 'Image is required.']);
        exit;
    }

    // Insert data into the database
    $query = "INSERT INTO lumber (type, length, width, thickness, qty, unitPrice, image_path) 
              VALUES ('$material_type', '$length', '$width', '$thickness', '$quantity', '$unit_price', '$imagePath')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Product created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating product: ' . mysqli_error($conn)]);
    }
}
?>
