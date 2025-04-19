<?php
// Authentication check
require_once 'auth.php';
require_once 'db.php'; // Ensure this file has mysqli connection as $conn

// Set header to return JSON
header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get POST data
$productId = isset($_POST['productId']) ? intval($_POST['productId']) : 0;
$category = isset($_POST['category']) ? strtolower($_POST['category']) : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';
$imagePath = isset($_POST['imagePath']) ? $_POST['imagePath'] : '';

// Validate inputs
if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

if ($category !== 'timber' && $category !== 'lumber') {
    echo json_encode(['success' => false, 'message' => 'Invalid category']);
    exit;
}

if ($action !== 'approve' && $action !== 'reject') {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

// Start transaction
mysqli_autocommit($conn, FALSE);

try {
    $pendingTable = 'pending' . $category;
    
    // Get the product from the pending table
    $stmt = mysqli_prepare($conn, "SELECT * FROM $pendingTable WHERE {$category}Id = ?");
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    
    if (!$product) {
        throw new Exception("Product not found");
    }
    
    if ($action === 'approve') {
        // Update is_approved to 1
        $stmt = mysqli_prepare($conn, "UPDATE $pendingTable SET is_approved = '1' WHERE {$category}Id = ?");
        mysqli_stmt_bind_param($stmt, "i", $productId);
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            throw new Exception("Failed to update approval status: " . mysqli_error($conn));
        }
  
        // Update is_approved to 1
$stmt = mysqli_prepare($conn, "UPDATE $pendingTable SET is_approved = '1' WHERE {$category}Id = ?");
mysqli_stmt_bind_param($stmt, "i", $productId);
$success = mysqli_stmt_execute($stmt);

if (!$success) {
    throw new Exception("Failed to update approval status: " . mysqli_error($conn));
}

// Copy the image file to the uploads directory
if (!empty($product['image'])) {
    // The source path is relative to this script
    $sourcePath = '../public/' . $product['image']; // Path from API to the image
    $uploadsDir = __DIR__ . '/uploads/'; // This is the destination directory within the API folder
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }
    
    // Get the filename from the path
    $filename = basename($product['image']);
    $destinationPath = $uploadsDir . $filename;
    
    // Copy the file
    if (file_exists($sourcePath)) {
        if (!copy($sourcePath, $destinationPath)) {
            throw new Exception("Failed to copy image file from $sourcePath to $destinationPath");
        }
        // If you want to use the new path in the database, modify the $product['image']
        // $product['image'] = 'uploads/' . $filename;
    } else {
        // Source file doesn't exist, but continue with approval
        error_log("Warning: Source image file not found: $sourcePath");
    }
    if (file_exists($sourcePath)) {
        if (copy($sourcePath, $destinationPath)) {
            // Update the image path to use the new location
            $product['image'] = 'uploads/' . $filename;
        } else {
            error_log("Warning: Failed to copy image file from $sourcePath to $destinationPath");
            // Continue with the original path
        }
    } else {
        error_log("Warning: Source image file not found: $sourcePath");
        // Continue with the original path
    }
}

// Insert into the target table based on category
// ... rest of your code ...
// Now $imagePath will be 'uploads/imagename'


// Now $imagePath will be: uploads\timber01.jpg

        // Insert into the target table based on category
        if ($category === 'timber') {
            
            $stmt = mysqli_prepare($conn, "INSERT INTO timber (type, diameter, qty, price, supplierId, image_path) 
                                   VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sidids", 
                $product['type'],
                $product['diameter'],
                $product['quantity'], // Maps to qty in timber table
                $product['unitprice'], // Maps to price in timber table
                $product['supplierId'],
                $product['image'] // Maps to image_path in timber table
            );
        } 
        elseif ($category === 'lumber') {
            $stmt = mysqli_prepare($conn, "INSERT INTO lumber (type, length, width, thickness, qty, unitPrice, image_path, is_deleted) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, '0')");
            mysqli_stmt_bind_param($stmt, "sdddiss", 
                $product['type'],
                $product['length'],
                $product['width'],
                $product['thickness'],
                $product['quantity'], // Maps to qty in lumber table
                $product['unitprice'], // Maps to unitPrice in lumber table
                $product['image'] // Maps to image_path in lumber table
            );
        }
        
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            throw new Exception("Failed to insert into $category table: " . mysqli_error($conn));
        }
        
        // Commit transaction
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Product approved successfully']);
    } 
    elseif ($action === 'reject') {
        // For rejection, delete the product from the pending table
        $stmt = mysqli_prepare($conn, "DELETE FROM $pendingTable WHERE {$category}Id = ?");
        mysqli_stmt_bind_param($stmt, "i", $productId);
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            throw new Exception("Failed to delete product: " . mysqli_error($conn));
        }
        
        // Commit transaction
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Product rejected successfully']);
    }
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Reset autocommit to true
    mysqli_autocommit($conn, TRUE);
}
?>