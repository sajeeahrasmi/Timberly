<?php

session_start();

$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;
$itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : null;
$userId = isset($_GET['userId']) ? intval($_GET['userId']) : null;


if (!$orderId || !$itemId || !$userId) {
    echo "Invalid request. Order details missing.";
    exit;
}
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
                            <img id="item-image" src="../images/bookshelf.jpg" alt="Item Image"> <!-- Image updates dynamically -->
                        </div>
                        <div class="item-info">
                            <p><strong>Description:</strong> <span id="description"></span></p>
                            <p><strong>Type of Wood:</strong> <span id="wood-type"></span></p>
                            <p><strong>Dimensions:</strong> <span id="dimensions"></span></p>
                            <p><strong>Quantity:</strong> <span id="quantity"></span></p>
                            <p><strong>Price:</strong> $<span id="price"></span></p>
                            <p><strong>Status:</strong> <span id="item-status" class="status-badge">Loading...</span></p>
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

</body>
</html>
