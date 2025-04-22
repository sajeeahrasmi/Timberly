<?php
header('Content-Type: application/json');
require '../../config/db_connection.php'; // Adjust this path as needed

session_start();

// Read raw JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
// if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($input['orderId'])) {
//     echo json_encode(['success' => false, 'message' => 'Invalid request']);
//     exit;
// }

$orderId = intval($input['orderId']);
if ($orderId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit;
}   
$customerId = null;
// if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['orderId'])) {
//     echo json_encode(['success' => false, 'message' => 'Invalid request']);
//     exit;
// }
// Prepare the statement to fetch customer ID from orders
$stmt = $conn->prepare("SELECT userId FROM orders WHERE orderId = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$stmt->bind_param('i', $orderId);
$stmt->execute();
$stmt->bind_result($uid);

if ($stmt->fetch()) {
    $customerId = $uid;
    echo json_encode(['success' => true, 'customerId' => $customerId]);
} else {
    echo json_encode(['success' => false, 'message' => 'No customer found for this order ID']);
}

if (!$customerId) {
    error_log("No customer found for orderId: " . $orderId);
    echo json_encode(['success' => false, 'message' => 'Customer not found for this orderId']);
    exit;
}
$stmt->close();


// Generate 6-digit OTP
$otp = rand(100000, 999999);

// get the latest notificationId from customerNotification table
$stmt = $conn->prepare("SELECT MAX(notificationId) FROM customerNotification");
$stmt->execute();

// Save notification to customerNotification table
$notificationId =100;
$stmt->bind_result($notificationId);
$stmt->fetch();
$stmt->close();
$notificationId = $notificationId ? $notificationId + 1 : 1; // Increment or set to 1 if no records exist
$fromId = $_SESSION['userId']; // Assuming this is the driver ID from session
$fromWhom = "Driver"; // Assuming this is the sender type
$message = "Your OTP for delivery is: $otp. Please share this with the driver.";
$userId = $customerId; // Assuming this is the customer ID

// echo ("Notification ID: " . $notificationId . "\n");
// echo ("User ID: " . $userId . "\n");
// echo ("From ID: " . $fromId . "\n");
// echo ("From Whom: " . $fromWhom . "\n");
// echo ("Message: " . $message . "\n");
// echo ("OTP: " . $otp . "\n");

$stmt = $conn->prepare("INSERT INTO customerNotification (notificationId, userId, fromId, fromWhom, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiiss", $notificationId, $userId, $fromId, $fromWhom, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'OTP sent successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save notification']);
}

$stmt->close();
$conn->close();
