<?php
include '../../config/db_connection.php'; // Ensure this file contains a working database connection.
session_start();
// Debug: log to check what was inserted
error_log("Inserted post for supplierId: " . $_SESSION['userId']);


if (isset($_POST['submit'])) {
    // Collect form data
    $category = $_POST['category'];
    $type = $_POST['type'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $info = $_POST['info'];


    // Check for empty fields
    if (empty($category) || empty($type) || empty($length) || empty($width) || empty($height) || empty($quantity) || empty($price)) {
        die("All fields are required.");
    }

    // Handle image upload
    $image = $_FILES['image']['name'];
    // $target = "uploads/" . basename($image);
    $target = "uploads/" . basename($image);


    // Ensure uploads directory exists and is writable
    if (!is_dir('uploads/')) {
        mkdir('uploads', 0777, true);  // Create uploads directory if not exists
    }

    if (!is_writable('uploads/')) {
        die("Uploads directory is not writable.");
    }

    // Move the uploaded file
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        die("Failed to upload image.");
    }

    // Insert data into the database
    $sql = "INSERT INTO `crudpost` (`category`, `type`, `length`, `width`, `height`, `quantity`, `price`, `info`, `image`, `supplierId`) 
            VALUES ('$category', '$type', '$length', '$width', '$height', '$quantity', '$price', '$info', '$image', '{$_SESSION['userId']}')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to display page after successful insertion
        // header("Location: displayPost.php");
        header("Location: ../supplier/displayPost.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>