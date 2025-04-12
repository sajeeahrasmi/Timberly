<?php

session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$query = "SELECT * FROM orderfurniture  WHERE id = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$orderId = $row['orderId'] ?? '0';
$itemId = $row['itemId'] ?? '0';
$type = $row['type'] ?? '0';
$qty = $row['qty'] ?? '0';
$size = $row['size'] ?? '0';
$details = $row['additionalDetails'] ?? '0';
$unitPrice = $row['unitPrice'] ?? '0';
$status = $row['status'] ?? '0';
$driverId = $row['driverId'] ?? '0';
$deliveryDate = $row['date'] ?? '0';
$reviewId = $row['reviewId'] ?? '0';



$query1 = "SELECT * FROM furnitures WHERE furnitureId = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $itemId);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$description = $row1['description'] ?? 'Unknown';
$image = $row1['image'] ?? '../images/furniture.jpg';
$category = $row1['category'] ?? '0';



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
    <title>Order Cart</title>

    <link rel="stylesheet" href="../customer/styles/orderWishlist.css">
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
                
                <div class="top">
                    <h2>Order Cart</h2>
                    <button id="action-button" class="button outline">Clear Cart</button>
                </div>

                <div class="bottom">
                    <div class="right">

                        <div class="cart-item">
                            <img src="../../public/images/table.jpg" alt="Product Image" class="product-image">
                            <div class="product-details">
                                <h2 class="product-title">Dining Table</h2>
                                <p class="product-material">Teak</p>
                                <p class="product-description">Length size 6' with glass </p>
                                <div class="quantity-selector">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" min="1" value="1">
                                </div>
                            </div>
                            <div class="price-details">
                                <p class="price-label">Product Price</p>
                                <p class="price">Rs. </p>
                                <p class="price-label">Total:</p>
                                <p class="price">Rs. </p>
                            </div>
                            <button class="remove-button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                        <!-- <div class="cart-item">
                            <img src="./images/pic2.jpg" alt="Product Image" class="product-image">
                            <div class="product-details">
                                <h2 class="product-title">Main Door</h2>
                                <p class="product-material">Mahogany</p>
                                <p class="product-description">Description</p>
                                <div class="quantity-selector">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" min="1" value="1">
                                </div>
                            </div>
                            <div class="price-details">
                                <p class="price-label">Item Price</p>
                                <p class="price">Rs. 2300</p>
                                <p class="price-label">Total:</p>
                                <p class="price">Rs. 2300</p>
                            </div>
                            <button class="remove-button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div> -->

                        
                        

                    </div>
                    
                    <div class="left">
                        <div class="order-summary">
                            <h3>Order Summary</h3>
                            <hr>
                            <p>No.of items: 01</p>
                            <p>Total: <span class="total-amount">Rs. </span></p>
                        </div>
                        <div class="button-container">
                            <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/products.html`">Continue Shopping</button>
                            <button class="button solid" onclick="window.location.href=`http://localhost/Timberly/public/customer/payment-details.html`">Order Now</button>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
   
    </div>

</body>
</html>
