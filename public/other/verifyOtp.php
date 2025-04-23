<?php
header('Content-Type: application/json');
require '../../config/db_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['orderId']) || !isset($data['otp'])) {
    echo json_encode(['success' => false, 'message' => 'Missing orderId or OTP']);
    exit;
}

$orderId = intval($data['orderId']);
$enteredOtp = $data['otp'];
$customerId = null;

// Step 1: Get customerId from the orderId
$stmt = $conn->prepare("SELECT userId FROM orders WHERE orderId = ?");
$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($uid);

if ($stmt->fetch()) {
    $customerId = $uid;
}
$stmt->close();

if (!$customerId) {
    echo json_encode(['success' => false, 'message' => 'Customer not found for orderId']);
    exit;
}

// Step 2: Get the latest OTP notification for the customer
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

if ($stmt->fetch()) {
    // Step 3: Extract OTP from message using regex
    preg_match('/\d{6}/', $message, $matches);
    if (!empty($matches)) {
        $storedOtp = $matches[0];
        if ($enteredOtp == $storedOtp) {
            echo json_encode(['success' => true, 'message' => 'OTP verified']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect OTP']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'OTP not found in message']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No OTP notification found']);
}

$stmt->close();
$conn->close();
