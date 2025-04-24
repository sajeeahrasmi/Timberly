<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

require '../../config/db_connection.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['orderId']) || !isset($data['otp'])) {
        throw new Exception("Missing orderId or OTP");
    }

    $orderId = intval($data['orderId']);
    $enteredOtp = trim($data['otp']);

    // Step 1: Get customerId
    $stmt = $conn->prepare("SELECT userId FROM orders WHERE orderId = ?");
    if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $stmt->bind_result($customerId);
    if (!$stmt->fetch()) {
        $stmt->close();
        throw new Exception("Customer not found for orderId: $orderId");
    }
    $stmt->close(); // ✅ CLOSE before next query

    // Step 2: Get latest OTP notification
    $stmt = $conn->prepare("
        SELECT message 
        FROM customerNotification 
        WHERE userId = ? AND fromWhom = 'Driver'
        ORDER BY notificationId DESC 
        LIMIT 1
    ");
    $stmt->bind_param('i', $customerId);
    $stmt->execute();
    $stmt->bind_result($message);
    if (!$stmt->fetch()) {
        $stmt->close();
        throw new Exception("No OTP notification found for this customer");
    }
    $stmt->close(); // ✅ CLOSE before using new statements

    // Step 3: Extract and compare OTP
    preg_match('/\d{6}/', $message, $matches);
    if (empty($matches)) {
        throw new Exception("OTP not found in message");
    }

    $storedOtp = $matches[0];
    if ($enteredOtp !== $storedOtp) {
        throw new Exception("Incorrect OTP");
    }

    // Step 4: Update order status to 'delivered' for all related tables
    $tables = ['orderfurniture', 'ordercustomizedfurniture', 'orderlumber'];
    foreach ($tables as $table) {
        $update = $conn->prepare("UPDATE $table SET status = 'delivered' WHERE orderId = ? AND status = 'finished'");
        $update->bind_param('i', $orderId);
        $update->execute();
        $update->close();
    }

    echo json_encode(['success' => true, 'message' => 'OTP verified and delivery completed']);
    exit;

} catch (Exception $e) {
    error_log("OTP verification error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
