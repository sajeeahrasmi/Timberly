<?php
include '../../config/db_connection.php';
session_start();

// Check supplier session
if (!isset($_SESSION['userId'])) {
    echo "Error: Supplier not logged in.";
    exit();
}

$supplierId = $_SESSION['userId'];
$postdate = date("Y-m-d");
$is_approved = '0'; // Default pending state
$is_approved = '0'; // Default pending state

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $price = $_POST['unitprice'];
    $info = $_POST['info'];
    $image = $_FILES['image'];

    // Image Upload
    $targetDir = "../Supplier/uploads/";
    $imageName = time() . "_" . basename($image["name"]);
    $targetFile = $targetDir . $imageName;

    if (!move_uploaded_file($image["tmp_name"], $targetFile)) {
        echo "Image upload failed.";
        exit();
    }

    $imagePath = "/Supplier/uploads/" . $imageName;

    if ($category === "Timber") {
        $diameter = isset($_POST['diameter']) ? $_POST['diameter'] : null;

        $stmt = $conn->prepare("INSERT INTO pendingtimber 
            (type, diameter, quantity, unitprice, info, image, supplierId, postdate, is_approved) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiisssss", 
            $type, $diameter, $quantity, $price, $info, $imagePath, $supplierId, $postdate, $is_approved
        );

    } elseif ($category === "Lumber") {
        // Lumber specific fields
        $type = isset($_POST['type']) ? $_POST['type'] : null;
        $length = isset($_POST['length']) ? $_POST['length'] : null;
        $width = isset($_POST['width']) ? $_POST['width'] : null;
        $thickness = isset($_POST['thickness']) ? $_POST['thickness'] : null;
    
        $stmt = $conn->prepare("INSERT INTO pendinglumber 
            (type, length, width, thickness, quantity, unitprice, info, image, supplierId, postdate, is_approved) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("siiiiississ", 
            $type, $length, $width, $thickness, $quantity, $price, $info, $imagePath, $supplierId, $postdate, $is_approved
        );
    

    } else {
        echo "Invalid category.";
        exit();
    }

    // Execute & handle result
    if ($stmt->execute()) {
        echo "<script>alert('Post submitted successfully!'); window.location.href = '\supplier\displayPost.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
