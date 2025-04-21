<?php
include '../../config/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}


if (isset($_GET['orderId'])) {
    $orderId = intval($_GET['orderId']);

    // Get userId from orders table
    $stmt = $conn->prepare("SELECT userId FROM orders WHERE orderId = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userId = $result->fetch_assoc()['userId'] ?? null;

    if ($userId) {
        // Get user details from user table
        $stmt = $conn->prepare("SELECT name, address, email, phone FROM user WHERE userId = ? AND role = 'customer'");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode([
                'success' => true,
                'data' => $row
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Customer not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
