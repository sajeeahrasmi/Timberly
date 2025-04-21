<?php
include '../db_connection.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['userId'])) {
    echo json_encode(["status" => "error", "message" => "Not authenticated"]);
    exit;
}

$sessionId = $_SESSION['userId'];
$orderId = $_POST['orderId'] ?? null;
$itemId = $_POST['itemId'] ?? null;

// Validate required fields
if (!$orderId || !$itemId) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "status" => "error",
        "message" => "File upload failed"
    ]);
    exit;
}

// Create upload directory if it doesn't exist
$uploadDir = "../../api/customerUploads/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generate unique filename with timestamp
$timestamp = time();
$originalFilename = basename($_FILES['image']['name']);
$newFilename = $timestamp . '_' . $originalFilename;
$uploadPath = $uploadDir . $newFilename;

// Move the uploaded file
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
    // Store path in database
    $imagePath = "../../api/customerUploads/" . $newFilename;
    
    // Update the ordercustmizedfurnitur table
    $query = "UPDATE ordercustomizedfurniture SET image = ? WHERE orderId = ? AND itemId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $imagePath, $orderId, $itemId);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Customized image uploaded successfully",
            "imagePath" => $imagePath
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . $stmt->error
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save the uploaded file"
    ]);
}
?>