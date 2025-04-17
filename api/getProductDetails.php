<?php
    include 'db.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $message = '';

    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['furnitureId'])) {
        $furnitureId = mysqli_real_escape_string($conn, $_GET['furnitureId']);
        $query = "SELECT * FROM furnitures WHERE furnitureId = ?";
        
        // Use prepared statement
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $furnitureId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (!$result) {
            $message = 'Error fetching furniture data: ' . mysqli_error($conn);
        } else {
            $product = mysqli_fetch_assoc($result);
            if (!$product) {
                $message = 'Product not found';
            }
        }
    }    

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['furnitureId'])) {
        $furnitureId = mysqli_real_escape_string($conn, $_GET['furnitureId']);
        
        // Handle delete operation
        if (isset($_POST['delete'])) {
            // First get the current image path to delete the file
            $query = "SELECT image FROM furnitures WHERE furnitureId = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $furnitureId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $currentProduct = mysqli_fetch_assoc($result);
            
            // Delete the product
            $deleteQuery = "DELETE FROM furnitures WHERE furnitureId = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmt, "s", $furnitureId);
            $deleteResult = mysqli_stmt_execute($stmt);
            
            if ($deleteResult) {
                // Delete the image file if it exists
                if (!empty($currentProduct['image']) && file_exists($currentProduct['image'])) {
                    unlink($currentProduct['image']);
                }
                $message = "Product deleted successfully!";
                // Redirect to products list after deletion
                header("Location: ../public/admin/postProducts.php");
                exit;
            } else {
                $message = "Error deleting product: " . mysqli_error($conn);
            }
        }
        
        // Handle save operation
        if (isset($_POST['save'])) {
            $description = trim($_POST['name']);
            $category = trim($_POST['category']);
            $type = trim($_POST['type']);
            $size = trim($_POST['size']);
            $additionalDetails = trim($_POST['additionalDetails']);
            $unitPrice = trim($_POST['unitPrice']);
            
            // Handle image upload
            $imageUpdate = '';
            if (!empty($_FILES['newImage']['name'])) {
                $targetDir = "../images/";
                
                // Create directory if it doesn't exist
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                
                // Generate unique filename
                $fileName = time() . '_' . basename($_FILES["newImage"]["name"]);
                $targetFile = $targetDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                
                // Check if file is an actual image
                $check = getimagesize($_FILES["newImage"]["tmp_name"]);
                if ($check !== false) {
                    // Check file size (limit to 5MB)
                    if ($_FILES["newImage"]["size"] <= 5000000) {
                        // Allow certain file formats
                        if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                            if (move_uploaded_file($_FILES["newImage"]["tmp_name"], $targetFile)) {
                                // Delete old image if exists
                                $query = "SELECT image FROM furnitures WHERE furnitureId = ?";
                                $stmt = mysqli_prepare($conn, $query);
                                mysqli_stmt_bind_param($stmt, "s", $furnitureId);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $currentProduct = mysqli_fetch_assoc($result);
                                
                                if (!empty($currentProduct['image']) && file_exists($currentProduct['image']) && $currentProduct['image'] != $targetFile) {
                                    unlink($currentProduct['image']);
                                }
                                
                                $imageUpdate = $targetFile;
                            } else {
                                $message = "Sorry, there was an error uploading your file.";
                            }
                        } else {
                            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        }
                    } else {
                        $message = "Sorry, your file is too large. Max size is 5MB.";
                    }
                } else {
                    $message = "File is not an image.";
                }
            }
            
            // Update product in database
            if (empty($message)) {
                $query = "UPDATE furnitures SET 
                    description = ?, 
                    category = ?, 
                    type = ?, 
                    size = ?, 
                    additionalDetails = ?, 
                    unitPrice = ?";
                
                $params = [$description, $category, $type, $size, $additionalDetails, $unitPrice];
                $types = "sssssd"; // string, string, string, string, string, double
                
                if (!empty($imageUpdate)) {
                    $query .= ", image = ?";
                    $params[] = $imageUpdate;
                    $types .= "s";
                }
                
                $query .= " WHERE furnitureId = ?";
                $params[] = $furnitureId;
                $types .= "s";
                
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                $result = mysqli_stmt_execute($stmt);
                
                if ($result) {
                    $message = "Product updated successfully!";
                    
                    // // Refresh product data
                    $query = "SELECT * FROM furnitures WHERE furnitureId = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "s", $furnitureId);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $product = mysqli_fetch_assoc($result);

                    header("Location: ../public/admin/productDetails.php?furnitureId=" . $furnitureId);
                    exit;
                } else {
                    $message = "Error updating product: " . mysqli_error($conn);
                }
            }
        }
    }
?>