<?php
header('Content-Type: application/json');
require_once '../../config/db_connection.php'; // Adjust this path as needed

$response = ['success' => false];

// Check for orderId parameter
if (!isset($_GET['orderId'])) {
    $response['message'] = 'Missing order ID';
    echo json_encode($response);
    exit;
}

$orderId = $_GET['orderId'];
$customerId = null;

// Check which order table the orderId exists in
//$orderTables = ['orderfurniture', 'ordercustomizedfurniture', 'orderlumber'];

    $stmt = $conn->prepare("SELECT userId FROM orders WHERE orderId = ?");
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $stmt->bind_result($uid);
    
    if ($stmt->fetch()) {
        $customerId = $uid;
        //$stmt->close();
        
    }
    $stmt->close();


if (!$customerId) {
    $response['message'] = 'Order not found in any table';
    echo json_encode($response);
    exit;
}

// Get customer address from user table
$stmt = $conn->prepare("SELECT address FROM user WHERE userId = ? AND role = 'customer'");
$stmt->bind_param('i', $customerId);
$stmt->execute();
$stmt->bind_result($address);

if ($stmt->fetch()) {
    $response['success'] = true;
    $response['deliveryLocation'] = $address;
} else {
    $response['message'] = 'Customer address not found';
}

$stmt->close();
$conn->close();

echo json_encode($response);
