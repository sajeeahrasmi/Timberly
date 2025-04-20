<?php
session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$query = "SELECT c.*, f.description, f.image, f.category, f.type, f.size, f.additionalDetails, f.unitPrice 
          FROM cart c 
          JOIN furnitures f ON c.productId = f.furnitureId 
          WHERE c.userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$totalItems = 0;
$totalAmount = 0;

$query2 = "SELECT 
    COUNT(*) AS selectedItemCount,
    SUM(c.qty * f.unitPrice) AS totalSelectedAmount
    FROM cart c
    JOIN furnitures f ON c.productId = f.furnitureId
    WHERE c.userId = ? AND c.selectToOrder = 'yes';
    ";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $userId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$selectedItemCount = $row2['selectedItemCount'] ?? '';
$totalSelectedAmount = $row2['totalSelectedAmount'] ?? '';

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
                    <h2>Cart</h2>
                    <button id="clear-cart-btn" class="button outline" onclick="clearCart(<?php echo $userId; ?>)">Clear Cart</button>
                </div>

                <div class="bottom">
                    <div class="right">
                        <?php 
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $totalItems++;
                                $itemTotal = $row['unitPrice'] * $row['qty'];
                                $totalAmount += $itemTotal;
                        ?>
                        <div class="cart-item" data-cart-id="<?php echo $row['cartId']; ?>">
                            <div class="selection-box">
                                <input type="checkbox" class="select-to-order" <?php echo ($row['selectToOrder'] == 'yes') ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo !empty($row['image']) ? '' . $row['image'] : '../images/furniture.jpg'; ?>" alt="<?php echo $row['description']; ?>" class="product-image">
                            <div class="product-details">
                                <h2 class="product-title"><?php echo $row['description']; ?></h2>
                                <p class="product-material"><?php echo $row['type']; ?></p>
                                <p class="product-description"><?php echo $row['size']; ?></p>
                                <p class="product-description"><?php echo  $row['additionalDetails']; ?></p>
                                <!-- <p class="product-description"><?php echo $row['size'] . ' ' . $row['additionalDetails']; ?></p> -->
                                <div class="quantity-selector">
                                    <label for="quantity-<?php echo $row['cartId']; ?>">Quantity:</label>
                                    <input type="number" id="quantity-<?php echo $row['cartId']; ?>" class="quantity-input" min="1" value="<?php echo $row['qty']; ?>">
                                </div>
                            </div>
                            <div class="price-details">
                                <p class="price-label">Product Price</p>
                                <p class="price">Rs. <?php echo number_format($row['unitPrice'], 2); ?></p>
                                <p class="price-label">Total:</p>
                                <p class="price item-total">Rs. <?php echo number_format($row['unitPrice']*$row['qty'], 2); ?></p>
                            </div>
                            <button class="remove-button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <?php 
                            }
                        } else {
                        ?>
                        <div class="empty-cart">
                            <i class="fa fa-shopping-cart"></i>
                            <p>Your cart is empty</p>
                            <button class="button solid" onclick="window.location.href='http://localhost/Timberly/public/products.php'">Shop Now</button>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>
                    
                    <div class="left">
                        <div class="order-summary">
                            <h3>Order Summary</h3>
                            <hr>
                            <p>No. of items: <span id="total-items"><?php echo $selectedItemCount; ?></span></p>
                            <p>Total: <span class="total-amount" id="total-amount">Rs. <?php echo number_format($totalSelectedAmount, 2); ?></span></p>
                        </div>
                        <div class="button-container">
                            <button class="button outline" onclick="window.location.href='http://localhost/Timberly/public/products.php'">Continue Shopping</button>
                            <!-- <button class="button solid" id="order-now-btn" <?php echo ($totalItems == 0) ? 'disabled' : ''; ?> onclick="processOrder(<?php echo $userId; ?>,<?php echo $selectedItemCount; ?>, <?php echo number_format($totalSelectedAmount, 2); ?> )">Order Now</button> -->
                            <button class="button solid" id="order-now-btn" <?php echo ($totalItems == 0) ? 'disabled' : ''; ?> onclick="processOrder(<?php echo $userId; ?>, <?php echo $selectedItemCount; ?>, <?php echo floatval($totalSelectedAmount); ?>)">Order Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../customer/scripts/orderCart.js"></script>
</body>
</html>