
<?php
// Include database connection
include 'db.php';

$orderId = $_GET['orderId']; // Get orderId from the query parameter

// Query to get the payment details from the payment table
$query = "SELECT sum(amount) AS amountPaid FROM payment WHERE orderId = ? AND viewed = '0'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $orderId); // bind orderId to the query
$stmt->execute();
$result = $stmt->get_result();

// Check if there's a result
if ($result->num_rows > 0) {
    $paymentDetails = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'amountPaid' => $paymentDetails['amountPaid']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Payment not found']);
}
?>
