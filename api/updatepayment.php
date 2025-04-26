<?php

require_once 'db.php';




$data = json_decode(file_get_contents("php://input"), true);

$orderId = $data['orderId'];
$amountPaid = $data['amountPaid'];


$sql = "SELECT totalAmount FROM orders WHERE orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    $totalAmount = $order['totalAmount'] ;

    
    $newTotalAmount = $totalAmount - $amountPaid;
   
   
    $paymentStatus = ($newTotalAmount <= 0) ? 'Paid' : 'Partially_Paid';

    // Update the order's total amount in the database
    /*$updateSql = "UPDATE orders SET totalAmount = ? ,paymentStatus = ? WHERE orderId = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('dsi', $newTotalAmount, $paymentStatus, $orderId);
    */
   
       
    echo json_encode([
        'success' => true,
        'newTotalAmount' => $newTotalAmount,
        'paymentStatus' => $paymentStatus
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
       
}

// Close the database connection
$conn->close();
?>
