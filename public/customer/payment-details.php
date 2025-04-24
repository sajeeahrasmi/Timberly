<?php

session_start();

$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$queryCat = "SELECT * FROM orders WHERE orderId = ?";
$stmtCat = $conn->prepare($queryCat);
$stmtCat->bind_param("i", $orderId);
$stmtCat->execute();
$resultCat = $stmtCat->get_result();
$orderData = $resultCat->fetch_assoc();

$category = $orderData['category'] ?? 'Unknown';
$status = $orderData['status'] ?? 'Unknown';
$totalAmount = $orderData['totalAmount'] ?? 0;
$itemQty = $orderData['itemQty'] ?? 0;
$paymentStatus = $orderData['paymentStatus'] ?? 'Unpaid';

echo "<script>console.log('Order Category: " . addslashes($category) . "');</script>";

$orderItems = [];

if ($category === 'Furniture') {
    $query = "SELECT f.description, o.itemId, o.qty, o.unitPrice 
              FROM orderfurniture o 
              JOIN furnitures f ON o.itemId = f.furnitureId 
              WHERE o.orderId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderItems = $stmt->get_result();

} elseif ($category === 'Lumber') {
    $query = "SELECT l.type, l.length, l.width, l.thickness, l.unitPrice, o.itemId, o.qty 
              FROM orderlumber o 
              JOIN lumber l ON o.itemId = l.lumberId 
              WHERE o.orderId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderItems = $stmt->get_result();

} elseif ($category === 'CustomisedFurniture') {
    $query = "SELECT o.itemId, o.category as description, o.qty,  o.unitPrice 
              FROM ordercustomizedfurniture o 
              WHERE o.orderId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderItems = $stmt->get_result();

} else {
    $orderItems = null;
}


$queryPay ="SELECT SUM(amount) AS totalPaid FROM payment WHERE orderId = ?";
$stmtPay = $conn->prepare($queryPay);
$stmtPay->bind_param("i", $orderId);
$stmtPay->execute();
$resultPay = $stmtPay->get_result();
$rowPay = $resultPay->fetch_assoc();
$paidAmount = $rowPay['totalPaid'] ?? 0;

$balance = $totalAmount - $paidAmount;

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>

    <link rel="stylesheet" href="../customer/styles/payment-details.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>


</head>

<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
        <div id="header"></div>

    <div class="content">                  
        <h2>Payment Details</h2>
        
        <div class="items-list">
            <h3>Order Items</h3>
            <?php if ($orderItems && $orderItems->num_rows > 0): ?>
                <?php while ($item = $orderItems->fetch_assoc()): ?>
                    <div class="item">
                        <span class="item-name">
                            <?php
                                echo "ID: " . $item['itemId'] . " - ";
                                if ($category === 'Lumber') {
                                    echo $item['type'] . " " . $item['length'] . "x" . $item['width'] . "x" . $item['thickness'];
                                } else {
                                    echo $item['description'];
                                }
                            ?>
                        </span>
                        <span class="item-price">
                            Qty: <?= $item['qty'] ?> &nbsp;&nbsp; 
                            Unit Price: Rs <?= number_format($item['unitPrice'], 2) ?>
                        </span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No order items found.</p>
            <?php endif; ?>
        </div>

        <div class="summary">
            <h3>Payment Summary</h3>
            <div class="summary-item">
                <span>Total Amount:</span>
                <span>Rs <?= number_format($totalAmount, 2) ?></span>
            </div>
            <div class="summary-item">
                <span>Paid Amount:</span>
                <span>Rs <?= number_format($paidAmount, 2) ?></span>
            </div>
            <div class="summary-item total">
                <span>Balance:</span>
                <span>Rs <?= number_format($balance, 2) ?></span>
            </div>
        </div>

        <div class="payment-input">
            <label for="payAmount">Enter Payment Amount (Rs):</label>
            <input type="number" id="payAmount" name="payAmount" min="0" placeholder="Enter amount">
        </div>
        
        <div class="payment-note">
            <p>Note:</p>
            <ul>
                <li>Minimum first-time payment is <strong>25% of total amount.</strong></li>
                <li>Minimum subsequent payment is <strong>Rs 10,000</strong>.</li>
            </ul>
        </div>

        <div class="button-container">
            <button class="button outline" onclick="history.back()">Cancel Payment</button>
            <!-- <button class="button solid" onclick="location.href='payment-method.php?order_id=<?= $orderId ?>'">Confirm Payment</button> -->
            <!-- <button class="button solid" onclick="location.href='checkout.php?orderId=<?= $orderId ?>'">Confirm Payment</button> -->
            <button class="button solid" onclick="processPayment()">Confirm Payment</button>
        </div>
    </div>
</div>

   
    </div>

</body>


<script>
    function processPayment() {
        const totalAmount = <?= $totalAmount ?>;
        const paidAmount = <?= $paidAmount ?>;
        const balance = <?= $balance ?>;
        const paymentStatus = "<?= $paymentStatus ?>";
        const orderStatus = "<?= $status ?>";
        const orderId = <?= $orderId ?>;

        const inputAmount = parseFloat(document.getElementById("payAmount").value);

        if (isNaN(inputAmount) || inputAmount <= 0) {
            alert("Please enter a valid payment amount.");
            return;
        }

        if(inputAmount > balance){
            alert("Please enter an amount less than balance.");
            return;
        }

        let finalAmount = inputAmount;
        const isFirstTimePayment = (paymentStatus === "Unpaid" || orderStatus === "Confirmed");

        if (isFirstTimePayment) {
            const minFirstPayment = totalAmount * 0.25;
            if (inputAmount < minFirstPayment) {
                // alert(`Minimum first-time payment is 25% of total: Rs ${minFirstPayment.toFixed(2)}.\nProceeding with minimum amount.`);
                const proceed = confirm(`Minimum first-time payment is 25% of total: Rs ${minFirstPayment.toFixed(2)}.\nDo you want to proceed with this amount?`);
                if (!proceed) {
                    return;
                }
                finalAmount = minFirstPayment;
            }
        } else {
            if (inputAmount < 10000) {
                // alert("Minimum subsequent payment is Rs 10,000.\nProceeding with minimum amount.");
                const proceed = confirm(`Minimum subsequent payment is Rs 10,000.\nProceeding with minimum amount.`);
                if (!proceed) {
                    return;
                }
                finalAmount = 10000;
            }
        }

        if (finalAmount > balance) {
            alert(`You cannot pay more than the remaining balance: Rs ${balance.toFixed(2)}.`);
            return;
        }

        // Proceed to Stripe checkout with correct amount
        window.location.href = `checkout.php?orderId=${orderId}&amount=${Math.round(finalAmount)}`;
    }
</script>
</html>
