<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];
echo "<script> console.log({$userId})</script>";
echo "<script> console.log('this is user')</script>";

include '../../config/db_connection.php';

$query1 = "SELECT * FROM user WHERE userId = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $userId);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$name = $row1['name'] ?? 'Driver';

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
                <img src="../images/final_logo.png" alt="Logo" style="height: 200px; margin: 0%; padding: 0%;"  />
            </div>
            <h1>Welcome  <?php echo $name; ?> !</h1>
            <div class="header-buttons">
                <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/other/driverProfile.php`">Profile</button>
                <button class="button solid" onclick="window.location.href=`http://localhost/Timberly/config/logout.php`">Logout</button>
            </div>
        </div>

        <div class="stats-container">
            <div class="card">
                <h3>Today's Deliveries</h3>
                <p>5/8</p>
            </div>
            <div class="card">
                <h3>Total Deliveries</h3>
                <p>10</p>
            </div>
        </div>

        <div class="delivery-list">
            <h2>Current Deliveries</h2>
            <div class="delivery-item">
                <div class="delivery-info">
                    <h4>Order Details</h4>
                    <p><strong>Order ID:</strong> #12345</p>
                    <p><strong>Items:</strong> 3</p>
                    <div class="items-list">
                        <p>- Item #123: Mahogany Chair</p>
                        <p>- Item #456: Teak Pantry</p>
                    </div>
                </div>
                <div class="delivery-actions">
                    <button class="button outline" onclick="showCustomerDetails(12345)">Customer Details</button>
                    <button class="button solid" id="delivery-btn-12345" onclick="handleDelivery(12345)">Start Delivery</button>
                </div>
            </div>
            <div class="delivery-item">
                <div class="delivery-info">
                    <h4>Order Details</h4>
                    <p><strong>Order ID:</strong> #12346</p>
                    <p><strong>Items:</strong> 2</p>
                    <div class="items-list">
                        <p>- Item #123: Nedum Table</p>
                        <p>- Item #456: Mahogany Main Door</p>
                    </div>
                </div>
                <div class="delivery-actions">
                    <button class="button outline" onclick="showCustomerDetails(12346)">Customer Details</button>
                    <button class="button solid" id="delivery-btn-12346" onclick="handleDelivery(12346)">Start Delivery</button>
                </div>
            </div>
            <div class="delivery-item">
                <div class="delivery-info">
                    <h4>Order Details</h4>
                    <p><strong>Order ID:</strong> #12346</p>
                    <p><strong>Items:</strong> 2</p>
                    <div class="items-list">
                        <p>- Item #123: Nedum Table</p>
                        <p>- Item #456: Mahogany Main Door</p>
                    </div>
                </div>
                <div class="delivery-actions">
                    <button class="button outline" onclick="showCustomerDetails(12346)">Customer Details</button>
                    <button class="button solid" id="delivery-btn-12346" onclick="handleDelivery(12346)">Start Delivery</button>
                </div>
            </div>
        </div>
    </div>

    <!-- OTP Verification Modal -->
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

    <!-- Customer Details Modal -->
    <div id="customerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('customerModal')">&times;</span>
            <h2>Customer Details</h2>
            <div class="customer-details" id="customerDetailsContent">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script src="scripts/driver.js"></script>
</body>
</html>