<?php
session_start();
require 'db.php'; // Ensure this contains your DB connection

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Fetch user ID from session
$userId = $_SESSION['userId'];

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$newPassword = $_POST['new_password'];

// Hash the password if it's being changed
if (!empty($newPassword)) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
} else {
    // If no new password is provided, we won't update the password
    $hashedPassword = null;
}

// Start a transaction
$conn->begin_transaction();

try {
    // Update user table (name and email)
    $stmt = $conn->prepare("UPDATE user SET name = ?, email = ? WHERE userId = ?");
    $stmt->bind_param("ssi", $name, $email, $userId);
    $result = $stmt->execute();
    
    if (!$result) {
        throw new Exception("Error updating user: " . $conn->error);
    }

    // If password is provided, update login table
    if ($hashedPassword) {
        $stmt = $conn->prepare("UPDATE login SET username = ? ,password = ? WHERE userId = ?");
        $stmt->bind_param("ssi", $name,$hashedPassword, $userId);
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception("Error updating password: " . $conn->error);
        }
    }

    // Commit the transaction
    $conn->commit();
    echo json_encode(['success' => 'Profile updated successfully!','userId' => $userId]);
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollback();
    echo json_encode(['error' => $e->getMessage(),'userId' => $userId]);
}
?>
