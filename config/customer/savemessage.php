<?php
$data = json_decode(file_get_contents("php://input"), true);


$senderType = $data['senderType']; // 'customer' or 'designer'
$message = $data['message'];
$messageType = $data['messageType'] ?? 'text';

include '../db_connection.php';
//find the sesion id based on productId and stuff
$itemId = $data['itemId'];
$orderId = $data['orderId'];

$query = "SELECT sessionId FROM designerchat WHERE itemId = ? AND orderId = ? ORDER BY sessionId DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $itemId, $orderId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$sessionId = $row['sessionId'] ?? null;
$stmt->close();


$query = "INSERT INTO designerchatmessages (sessionId, senderType, message, messageType) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $sessionId, $senderType, $message, $messageType);

$success = $stmt->execute();

$response = ['success' => $success];
if (!$success) {
    $response['error'] = $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
