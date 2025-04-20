<?php
include '../db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);
$orderId = $data['orderId'] ?? null;
$itemId = $data['itemId'] ?? null;

if ($orderId && $itemId) {
    $query = "SELECT sessionId FROM designerchat WHERE orderId = ? AND itemId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $orderId, $itemId);
    $stmt->execute();
    $result = $stmt->get_result();

    $sessionIds = [];
    while ($row = $result->fetch_assoc()) {
        $sessionIds[] = $row['sessionId'];
    }

    if (!empty($sessionIds)) {
        $placeholders = implode(',', array_fill(0, count($sessionIds), '?'));
        $types = str_repeat('i', count($sessionIds));

        $query = "SELECT messageId, sessionId, senderType, messageType, message
                  FROM designerchatmessages 
                  WHERE sessionId IN ($placeholders) 
                  ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$sessionIds);
        $stmt->execute();
        $result = $stmt->get_result();

        $messages = [];
        while ($row = $result->fetch_assoc()) {
            // messageContent will just mirror message, since it already has the correct path
            $row['messageContent'] = $row['message'];
            $messages[] = $row;
        }
        
        echo json_encode($messages);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
