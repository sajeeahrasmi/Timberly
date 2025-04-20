<?php
// Get raw POST data and decode JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validate and sanitize input
$orderId = intval($data['productId']);
$itemId = intval($data['productName']);

include '../db_connection.php';

// Prepare and execute SQL to insert chat session
$query = "INSERT INTO designerchat (orderId, itemId) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $orderId, $itemId);
$success = $stmt->execute();

// Initialize response array
$response = ['success' => $success];

if (!$success) {
    $response['error'] = $stmt->error;
}

// Fetch existing messages from the designerchatmessages table
// Using a JOIN to get all messages related to the specific orderId and itemId
$query = "SELECT dm.messageId, dm.senderType, dm.message, dm.messageType
          FROM designerchatmessages dm
          JOIN designerchat dc ON dm.sessionId = dc.sessionId
          WHERE dc.orderId = ? AND dc.itemId = ? ORDER BY dm.messageId ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $orderId, $itemId);
$stmt->execute();
$result = $stmt->get_result();

// Prepare messages array
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

// Add messages to the response
$response['messages'] = $messages;

// Close connections
$stmt->close();
$conn->close();

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
