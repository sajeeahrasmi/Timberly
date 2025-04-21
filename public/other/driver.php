<?php

session_start();
include 'getCurrentDeliveries.php';

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';
include 'getDeliveryStats.php'; // include the stats logic

// Get driver name
$stmt = $conn->prepare("SELECT name FROM user WHERE userId = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$name = $result->fetch_assoc()['name'] ?? 'Driver';

// Get delivery stats
$stats = getDeliveryStats($conn, $userId);
$todayDeliveries = $stats['todayDeliveries'];
$totalDeliveries = $stats['totalDeliveries'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <link rel="stylesheet" href="styles/driver.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="../images/final_logo.png" alt="Logo" style="height: 200px; margin: 0%; padding: 0%;" />
            </div>
            <h1>Welcome <?php echo $name; ?>!</h1>
            <div class="header-buttons">
                <button class="button outline" onclick="window.location.href='http://localhost/Timberly/public/other/driverProfile.php'">Profile</button>
                <button class="button solid" onclick="window.location.href='http://localhost/Timberly/config/logout.php'">Logout</button>
            </div>
        </div>

        <div class="stats-container">
            <div class="card">
                <h3>Today's Deliveries</h3>
                <p><?php echo $todayDeliveries; ?></p>
            </div>
            <div class="card">
                <h3>Total Deliveries</h3>
                <p><?php echo $totalDeliveries; ?></p>
            </div>
        </div>

        <div class="delivery-list">
            <h2>Current Deliveries</h2>
            <?php
            $deliveries = getCurrentDeliveries($conn, $userId);

            if (empty($deliveries)) {
                echo "<p>No pending deliveries assigned to you.</p>";
            } else {
                foreach ($deliveries as $orderId => $items) {
                    echo '<div class="delivery-item">';
                    echo '<div class="delivery-info">';
                    echo "<h4>Order Details</h4>";
                    echo "<p><strong>Order ID:</strong> #$orderId</p>";
                    echo "<p><strong>Items:</strong> " . count($items) . "</p>";
                    echo '<div class="items-list">';
                    foreach ($items as $item) {
                        echo "<p>- Item #{$item['itemId']}: {$item['description']} ({$item['type']})</p>";
                    }
                    echo '</div></div>';
                    echo '<div class="delivery-actions">';
                    echo "<button class='button outline' onclick='showCustomerDetails($orderId)'>Customer Details</button>";
                    echo "<button class='button solid' id='delivery-btn-$orderId' onclick='handleDelivery($orderId)'>Start Delivery</button>";
                    echo '</div></div>';
                }
            }
            ?>
        </div>
    </div>

    <!-- OTP Modal -->
    <div id="otpModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('otpModal')">&times;</span>
            <h2>Verify Delivery</h2>
            <div class="input-group">
                <label for="otp">Enter OTP received from customer</label>
                <input type="text" id="otp" maxlength="6" placeholder="Enter 6-digit OTP">
            </div>
            <button class="button solid" onclick="verifyOTP()">Verify & Complete</button>
        </div>
    </div>

    <!-- Customer Modal -->
    <div id="customerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('customerModal')">&times;</span>
            <h2>Customer Details</h2>
            <div class="customer-details" id="customerDetailsContent">
                <!-- Populated via JavaScript -->
            </div>
        </div>
    </div>

    <script src="scripts/driver.js"></script>
</body>
</html>
