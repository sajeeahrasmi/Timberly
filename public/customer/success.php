<?php
session_start();
include '../../config/db_connection.php';

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;
$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : null;

if (!$orderId || !$amount) {
    die("Missing order ID or amount.");
}

$now = time(); 
$sessionKey = $orderId . '_' . $amount;

if (isset($_SESSION['paid_once'][$sessionKey])) {
    $lastTime = $_SESSION['paid_once'][$sessionKey];
    if ($now - $lastTime < 120) { 
        header("Location: orderHistory.php");
        exit();
    }
}

$_SESSION['paid_once'][$sessionKey] = $now;

$paymentMode = 'Stripe';
$paymentDate = date('Y-m-d');

$conn->begin_transaction();

try {
  
    $insertQuery = "INSERT INTO payment (orderId, amount, date) VALUES ( ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ids", $orderId, $amount, $paymentDate);
    $stmt->execute();

  
    $orderQuery = "SELECT paymentStatus, status, totalAmount FROM orders WHERE orderId = ?";
    $stmtOrder = $conn->prepare($orderQuery);
    $stmtOrder->bind_param("i", $orderId);
    $stmtOrder->execute();
    $resultOrder = $stmtOrder->get_result();
    $orderData = $resultOrder->fetch_assoc();

    $paymentStatus = $orderData['paymentStatus'];
    $orderStatus = $orderData['status'];
    $totalAmount = $orderData['totalAmount'];

 
    if ($paymentStatus === 'Unpaid' || $orderStatus === 'Confirmed') {
        $updateQuery = "UPDATE orders SET paymentStatus = 'Partially_Paid', status = 'Processing' WHERE orderId = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param("i", $orderId);
        $stmtUpdate->execute();
    }

    
    $queryPay = "SELECT SUM(amount) AS totalPaid FROM payment WHERE orderId = ?";
    $stmtPay = $conn->prepare($queryPay);
    $stmtPay->bind_param("i", $orderId);
    $stmtPay->execute();
    $resultPay = $stmtPay->get_result();
    $rowPay = $resultPay->fetch_assoc();
    $totalPaid = $rowPay['totalPaid'] ?? 0;

  
    if ($totalPaid >= $totalAmount) {
        $stmtFull = $conn->prepare("UPDATE orders SET paymentStatus = 'Paid' WHERE orderId = ?");
        $stmtFull->bind_param("i", $orderId);
        $stmtFull->execute();
    }

    $queryCat = "SELECT category FROM orders WHERE orderId = ?";
    $stmtCat = $conn->prepare($stmtCat);
    $stmtCat->bind_param("i", $orderId);
    $stmtCat->execute();
    $resultCat = $stmtCat->get_result();
    $rowCat = $resultCat->fetch_assoc();
    $category = $rowCat['category'];

    if($category === 'Furniture'){
        $query = "UPDATE orderfurniture SET status = 'Approved' WHERE orderId = ? AND status = 'Pending'";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
    }

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    die("Transaction failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../customer/styles/payment-success.css">
    <style>
        .success-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            background: #f8fff8;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .receipt {
            text-align: left;
            margin: 20px 0;
            padding: 15px;
            background: #e8f5e9;
            border-radius: 5px;
            border: 1px solid #c8e6c9;
        }
        .button {
            padding: 10px 20px;
          
            background: #895D47;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background: #B18068;
        }

    </style>
</head>

<body>
    <div class="success-container">
        <h1>Payment Receipt</h1>
        <div class="receipt">
            <p><strong>Order ID:</strong> <?= htmlspecialchars($orderId) ?></p>
            <p><strong>Paid Amount:</strong> Rs <?= number_format($amount, 2) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($paymentDate) ?></p>
            <!-- <p><strong>Payment Method:</strong> <?= htmlspecialchars($paymentMode) ?></p> -->
        </div>
        <p>Thanks for your order!</p>
        <button onclick="window.location.href='orderHistory.php'" class="button">Go to Order History</button>
    </div>
</body>
</html>
