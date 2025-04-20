<?php

session_start();

$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;
$itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : null;
// $userId = isset($_GET['userId']) ? intval($_GET['userId']) : null;


if (!$orderId || !$itemId ) {
    echo "Invalid request. Order details missing.";
    exit;
}

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';


$query = "SELECT l.type, l.length, l.width, l.thickness, l.unitPrice, l.qty as maxQty, o.* FROM orderlumber o JOIN lumber l ON o.itemId = l.lumberId  WHERE o.itemId = ? AND o.orderId = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $itemId, $orderId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$orderId = $row['orderId'] ?? '0';
$itemId = $row['itemId'] ?? '0';
$type = $row['type'] ?? '0';
$qty = $row['qty'] ?? '0';
$length = $row['length'] ?? '0';
$width = $row['width'] ?? '0';
$thickness = $row['thickness'] ?? '0';
// $details = $row['additionalDetails'] ?? '0';
$unitPrice = $row['unitPrice'] ?? '0';
$status = $row['status'] ?? '0';
$driverId = $row['driverId'] ?? '0';
$deliveryDate = $row['date'] ?? '';
$reviewId = $row['reviewId'] ?? '0';
$maxQty = $row['maxQty'] ?? 0;


$query2 = "SELECT name, phone, vehicleNo FROM user JOIN driver ON driver.driverId = user.userId WHERE user.userId = ? ";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $driverId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$name = $row2['name'] ?? '';
$phone = $row2['phone'] ?? '';
$vehicleNo = $row2['vehicleNo'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Raw Materials</title>

    <link rel="stylesheet" href="../customer/styles/trackOrderDetails.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/trackOrder.js" defer></script> <!-- New JS File -->

</head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">  
                <div class="item-detail">
                    <h2 id="order-title">Order #<?php echo $orderId; ?></h2>
                    <h3 id="item-title">Item #<?php echo $itemId; ?></h3>

                    <div class="item-container">
                        <div class="item-image">
                            <img id="item-image" src="../images/lumber.jpg" alt="Item Image"> 
                        </div>
                        <div class="item-info">
                            <p><strong>Description:</strong> <span id="description">Lumber</span></p>
                            <p><strong>Type of Wood:</strong> <span id="wood-type"><?php echo $type ?></span></p>
                            <p><strong>Dimensions:</strong> <span id="dimensions"><?php echo $length ?> m x <?php echo $width ?> mm x <?php echo $thickness ?> mm</span></p>
                            <p><strong>Quantity:</strong> <span id="quantity"><?php echo $qty ?></span></p>
                            <p><strong>Price:</strong><span id="price"><?php echo $unitPrice ?></span></p>
                            <p><strong>Status:</strong> <span id="item-status" class="status-badge">Delivered</span></p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button id="edit-btn" class="button outline" disabled>Edit Item</button>
                        <button id="view-location-btn" class="button outline" disabled>Delivery Detail</button>
                        <button id="leave-review-btn" class="button outline" disabled>Leave Review</button>
                    </div>
                </div>     
            </div>
        </div>
    </div>

    <div id="overlay" class="overlay" onclick="closePopup()"></div>

    <div id="edit-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Edit Item Details</h2>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="edit-qty" min = 1 max =<?php echo $maxQty ?>  value="<?php echo $qty ?>">
                </div>
                <script>
                    document.getElementById("edit-qty").value = "<?php echo $qty ?>"; 
                </script>
                <button onclick="updateQuantity(<?php echo $orderId ?>, <?php echo $itemId ?>, <?php echo $maxQty ?>)">Update</button>           
        </div>
    </div>

    <div id="delivery-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Delivery Information</h2>
            <p><strong>Driver Name:</strong> <?php echo $name ?></p>
            <p><strong>Vehicle Number:</strong> <?php echo $vehicleNo ?></p>
            <p><strong>Expected Delivery:</strong> <?php echo $deliveryDate ?></p>
            <p><strong>Contact Number:</strong> <?php echo $phone ?></p>
            <button class="button outline">View Location</button>
        </div>
    </div>

    <div id="review-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Leave a Review</h2>
            <textarea placeholder="Write your review here..." id="review-text"></textarea>
            <button class="btn btn-review" onclick="submitReview(<?php echo $orderId ?>, <?php echo $itemId ?>)">Submit Review</button>
        </div>
    </div>
</body>
</html>
