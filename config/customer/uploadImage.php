<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];

    $itemId = $_POST['itemId'];
    $orderId = $_POST['orderId'];
    $senderType = isset($_POST['senderType']) ? $_POST['senderType'] : null;
    $messageType = 'image';
    $senderType = isset($_POST['senderType']) ? $_POST['senderType'] : 'null';

    // Get sessionId from designerchat table
    $stmt = $conn->prepare("SELECT sessionId FROM designerchat WHERE itemId = ? AND orderId = ? LIMIT 1");
    $stmt->bind_param("ii", $itemId, $orderId);
    $stmt->execute();
    $stmt->bind_result($sessionId);
    $stmt->fetch();
    $stmt->close();

    if (!$sessionId) {
        echo json_encode(['success' => false, 'error' => 'Session not found']);
        exit;
    }

    if (isset($_FILES['image'])) {
        $uploadDir = '../../api/customerUploads/';
        $fileName = time() . "_{$itemId}_images.png";
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $relativePath = $uploadPath;

            $stmt = $conn->prepare("INSERT INTO designerchatmessages (sessionId, senderType, message, messageType) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $sessionId, $senderType, $relativePath, $messageType);
            $stmt->execute();
            $stmt->close();
            $response = [
                'status' => 'success',
                'imageUrl' => $relativePath
            ];
            
        } else {
            $response = ['success' => false, 'error' => 'Failed to move file'];
        }
    } else {
        $response = ['success' => false, 'error' => 'No file uploaded'];
    }

    echo json_encode($response);
}
?>
