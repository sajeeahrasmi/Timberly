<?php
session_start();
include '../../config/db_connection.php';
include 'getCurrentDeliveries.php';
include 'getDeliveryStats.php'; // include the stats logic

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];

// Get driver name
$stmt = $conn->prepare("SELECT name FROM user WHERE userId = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$name = $result->fetch_assoc()['name'] ?? 'Driver';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery History</title>
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
                <input type="hidden" id="driverAvailable" value="NO">
                <button id="availabilityBtn" class="button solid" onclick="toggleAvailability()">
                Not Available ❌
                </button>
                <button class="button outline" onclick="window.location.href='http://localhost/Timberly/public/other/driver.php'">Dashboard</button>
                <button class="button outline" onclick="window.location.href='http://localhost/Timberly/public/other/driverProfile.php'">Profile</button>
                <button class="button solid" onclick="window.location.href='http://localhost/Timberly/config/logout.php'">Logout</button>
            </div>
        </div>


        <div class="delivery-list">
        <h2>Delivery History</h2>
<?php
include 'getDeliveryHistory.php';
$history = getDeliveryHistory($conn, $userId);

if (empty($history)) {
    echo "<p>No completed deliveries found.</p>";
} else {
    foreach ($history as $orderId => $items) {
        echo '<div class="delivery-item">';
        echo "<div class='delivery-info'>";
        echo "<h4>Order ID: #$orderId</h4>";
        echo "<p><strong>Items Delivered:</strong> " . count($items) . "</p>";
        echo '<div class="items-list">';
        foreach ($items as $item) {
            echo "<p>- {$item['type']} (#{$item['itemId']}): {$item['description']} ({$item['qty']} pcs)</p>";
        }
        echo '</div></div></div>';
    }
}
?>

        </div>
        <script src="scripts/driver.js"></script> 
</body>
</html>