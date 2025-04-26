
<?php

include 'db.php';

$orderId = $_GET['orderId']; 


$query = "SELECT sum(amount) AS amountPaid FROM payment WHERE orderId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $orderId); 
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $paymentDetails = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'amountPaid' => $paymentDetails['amountPaid']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Payment not found']);
}
?>
