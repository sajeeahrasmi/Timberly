<?php
    include('db.php');

    // Initialize variables
    $message = '';

    // Handle POST requests
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['lumberId'])) {
        $lumberId = mysqli_real_escape_string($conn, $_GET['lumberId']);
        $query = "SELECT * FROM lumber WHERE lumberId = ?";
        
        // Use prepared statement
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $lumberId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (!$result) {
            $message = 'Error fetching lumber data: ' . mysqli_error($conn);
        } else {
            $lumber = mysqli_fetch_assoc($result);
            if (!$lumber) {
                $message = 'Lumber not found';
            }
        }
    }    

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['lumberId'])) {
        $lumberId = mysqli_real_escape_string($conn, $_GET['lumberId']);
        
        // Handle delete operation
        if (isset($_POST['delete'])) {
            // First get the current image path to delete the file
            $query = "SELECT image_path FROM lumber WHERE lumberId = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $lumberId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $currentProduct = mysqli_fetch_assoc($result);
            
            // Delete the product
            $deleteQuery = "DELETE FROM lumber WHERE lumberId = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmt, "s", $lumberId);
            $deleteResult = mysqli_stmt_execute($stmt);
            
            if ($deleteResult) {
                // Delete the image file if it exists
                if (!empty($currentProduct['image']) && file_exists($currentProduct['image'])) {
                    unlink($currentProduct['image']);
                }
                $message = "Product deleted successfully!";
                // Redirect to products list after deletion
                header("Location: ../public/admin/postRawLumber.php");
                exit;
            } else {
                $message = "Error deleting lumber: " . mysqli_error($conn);
            }
        }
        
        // Handle save operation
        if (isset($_POST['save'])) {
            $type = trim($_POST['type']);
            $length = trim($_POST['length']);
            $width = trim($_POST['width']);
            $thickness = trim($_POST['thickness']);
            $qty = trim($_POST['qty']);
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
                                $query = "SELECT image_path FROM lumber WHERE lumberId = ?";
                                $stmt = mysqli_prepare($conn, $query);
                                mysqli_stmt_bind_param($stmt, "s", $lumberId);
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
                $query = "UPDATE lumber SET 
                    type = ?, 
                    length = ?, 
                    width = ?, 
                    thickness = ?, 
                    qty = ?, 
                    unitPrice = ?";
                
                $params = [$type, $length, $width, $thickness, $qty, $unitPrice];
                $types = "sdddid"; // string, double, double, double, int, double
                
                if (!empty($imageUpdate)) {
                    $query .= ", image = ?";
                    $params[] = $imageUpdate;
                    $types .= "s";
                }
                
                $query .= " WHERE lumberId = ?";
                $params[] = $lumberId;
                $types .= "s";
                
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                $result = mysqli_stmt_execute($stmt);
                
                if ($result) {
                    $message = "Product updated successfully!";
                    
                    // // Refresh product data
                    $query = "SELECT * FROM lumber WHERE lumberId = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "s", $lumberId);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $product = mysqli_fetch_assoc($result);

                    header("Location: ../public/admin/lumberDetails.php?lumberId=$lumberId&message=" . urlencode($message));
                    exit;
                } else {
                    $message = "Error updating product: " . mysqli_error($conn);
                }
            }
        }
    }
?>