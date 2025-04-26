<?php
require_once 'db.php'; // adjust the path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'] ?? '';
    $itemId = $_POST['itemId'] ?? '';
    $width = $_POST['width'] ?? '';
    $length = $_POST['length'] ?? '';
    $thickness = $_POST['thickness'] ?? '';
   // $orderType = $_POST['orderType'] ?? '';

    if (!$orderId || !$itemId || !$width || !$length || !$thickness ) {
        echo json_encode(['error' => 'Missing or invalid data.']);
        http_response_code(400);
        exit;
    }

    

    $stmt = $conn->prepare("UPDATE ordercustomizedfurniture SET width = ?, length = ?, thickness = ? WHERE orderId = ? AND itemId = ?");
    $stmt->bind_param("dddii", $width, $length, $thickness, $orderId, $itemId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update dimensions.']);
        http_response_code(500);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
}
