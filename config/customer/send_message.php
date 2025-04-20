<?php
include '../db_connection.php';
session_start();

header('Content-Type: application/json');

// Read JSON body
$data = json_decode(file_get_contents('php://input'), true);

// Extract values safely
$message = $data['message'] ?? null;
$orderId = $data['orderId'] ?? null;
$itemId = $data['itemId'] ?? null;
$userId = $data['userId'] ?? null;
$imagePath = $data['imagePath'] ?? null;  // NEW for image support
$sessionId = $_SESSION['userId'] ?? null;

// Input validation
if (($message || $imagePath) && $orderId && $itemId && $userId && $sessionId) {

    // Determine message type
    $messageType = $imagePath ? 'image' : 'text';
    $finalMessage = $imagePath ?? $message;
    //first need to enter to the designerchat table then detch the sessionId and do the rest
    $query = "INSERT INTO designerchat (orderId, itemId) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $orderId, $itemId);
    $stmt->execute();
    
    //get session id based on orderId and itemId
    $query = "SELECT sessionId FROM designerchat WHERE orderId = ? AND itemId = ? ORDER BY sessionId DESC LIMIT 1";
    $stmt = $conn->prepare($query);

    $stmt->bind_param("ii", $orderId, $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $sessionId = $row['sessionId'];
    

    // I    nsert into designerchatmessages
    $query = "INSERT INTO designerchatmessages (sessionId, message, messageType) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $sessionId, $finalMessage, $messageType);
    $stmt->execute();

    // Insert into notification table
    $notificationMessage = ($messageType === 'image') ? "Designer sent an image." : "New message from the designer.";
    $notificationQuery = "INSERT INTO customernotification (userId,  fromWhom, message) VALUES (?,  'Designer', ?)";
    $notificationStmt = $conn->prepare($notificationQuery);
    $notificationStmt->bind_param("is", $userId, $notificationMessage);
    $notificationStmt->execute();

    echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);

} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
}
?>