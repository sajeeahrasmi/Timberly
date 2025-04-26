<?php

require_once 'auth.php';
require_once 'db.php'; 


header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}


$productId = isset($_POST['productId']) ? intval($_POST['productId']) : 0;
$category = isset($_POST['category']) ? strtolower($_POST['category']) : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';
$imagePath = isset($_POST['imagePath']) ? $_POST['imagePath'] : '';


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


mysqli_autocommit($conn, FALSE);

try {
    $pendingTable = 'pending' . $category;
    
    
    $stmt = mysqli_prepare($conn, "SELECT * FROM $pendingTable WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    
    if (!$product) {
        throw new Exception("Product not found");
    }
    
    if ($action === 'approve') {
       
        $stmt = mysqli_prepare($conn, "UPDATE $pendingTable SET status = 'Approved' WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $productId);
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            throw new Exception("Failed to update approval status: " . mysqli_error($conn));
        }
  
        
$stmt = mysqli_prepare($conn, "UPDATE $pendingTable SET status = 'Approved' WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $productId);
$success = mysqli_stmt_execute($stmt);

if (!$success) {
    throw new Exception("Failed to update approval status: " . mysqli_error($conn));
}


if (!empty($product['image'])) {
    
    $sourcePath = '../public/' . $product['image']; 
    $uploadsDir = __DIR__ . '/uploads/'; 
    
    
    if (!file_exists($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }
    
    
    $filename = basename($product['image']);
    $destinationPath = $uploadsDir . $filename;
    
    
    if (file_exists($sourcePath)) {
        if (!copy($sourcePath, $destinationPath)) {
            throw new Exception("Failed to copy image file from $sourcePath to $destinationPath");
        }
        
        // $product['image'] = 'uploads/' . $filename;
    } else {
        
        error_log("Warning: Source image file not found: $sourcePath");
    }
    if (file_exists($sourcePath)) {
        if (copy($sourcePath, $destinationPath)) {
            
            $product['image'] = 'uploads/' . $filename;
        } else {
            error_log("Warning: Failed to copy image file from $sourcePath to $destinationPath");
            
        }
    } else {
        error_log("Warning: Source image file not found: $sourcePath");
        
    }
}


        if ($category === 'timber') {
            
            $stmt = mysqli_prepare($conn, "INSERT INTO timber (type, diameter, qty, price, supplierId, image_path) 
                                   VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sidids", 
                $product['type'],
                $product['diameter'],
                $product['quantity'], 
                $product['unitprice'], 
                $product['supplierId'],
                $product['image'] 
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
                $product['quantity'], 
                $product['unitprice'], 
                $product['image'] 
            );
        }
        
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            throw new Exception("Failed to insert into $category table: " . mysqli_error($conn));
        }
        
       
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Product approved successfully']);
    } 
    elseif ($action === 'reject') {
        
        $stmt = mysqli_prepare($conn, "UPDATE $pendingTable SET status = 'Rejected' WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $productId);
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            throw new Exception("Failed to delete product: " . mysqli_error($conn));
        }
        
        
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Product rejected successfully']);
    }
} catch (Exception $e) {
    
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    
    mysqli_autocommit($conn, TRUE);
}
?>