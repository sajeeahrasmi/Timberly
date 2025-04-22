<?php
header('Content-Type: application/json');
require '../db/dbConnection.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['orderId'])) {
    echo json_encode(['success' => false, 'message' => 'Missing orderId']);
    exit;
}

$orderId = intval($data['orderId']);
$customerId = null;

// Search in multiple order tables
$tables = ['orders', 'orderfurniture', 'ordercustomizedfurniture', 'orderlumber'];
foreach ($tables as $table) {
    $stmt = $conn->prepare("SELECT userId FROM `$table` WHERE orderId = ?");
    if (!$stmt) continue;

    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $stmt->bind_result($uid);

    if ($stmt->fetch()) {
        $check = $conn->prepare("SELECT id FROM user WHERE id = ? AND role = 'customer'");
        $check->bind_param("i", $uid);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $customerId = $uid;
            $check->close();
            $stmt->close();
            break;
        }

        $check->close();
    }

    $stmt->close();
}

if (!$customerId) {
    echo json_encode(['success' => false, 'message' => 'Customer not found']);
    exit;
}

// Generate random 6-digit OTP
$otp = random_int(100000, 999999);
$message = "Your delivery OTP is: $otp";

// Insert into customerNotification table
$insert = $conn->prepare("INSERT INTO customerNotification (customerId, sender, message, orderId) VALUES (?, 'driver', ?, ?)");
if ($insert) {
    $insert->bind_param("isi", $customerId, $message, $orderId);
    if ($insert->execute()) {
        echo json_encode(['success' => true, 'otp' => $otp]); // Just for debug; remove `otp` later
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send notification']);
    }
    $insert->close();
} else {
    echo json_encode(['success' => false, 'message' => 'DB Insert failed']);
}

$conn->close();
