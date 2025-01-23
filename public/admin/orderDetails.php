<?php
// Database connection placeholder
// include('db_connection.php');

// Initialize variables
$message = '';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? '';
    $products = $_POST['product'] ?? [];
    $prices = $_POST['price'] ?? [];
    $quantities = $_POST['quantity'] ?? [];

    $productData = []; // To store processed products

    $order_datetime = $_POST['order_datetime'] ?? '';
    $customer = $_POST['customer'] ?? '';
    $delv_address = $_POST['delv_address'] ?? '';
    $amount = $_POST['amount'] ?? 0;

    $transact_mode = $_POST['transact_mode'] ?? '';
    $transact_date = $_POST['transact_date'] ?? '';
    $transact_amount = $_POST['transact_amount'] ?? 0;

    if (isset($_POST['save'])) {
        // Update product logic
        // $query = "UPDATE products SET name='$name', category='$category', description='$description', price='$price', stock='$stock', visibility='$visibility' WHERE id='$prod_id'";
        // mysqli_query($db_connection, $query);

        $message = 'Product updated successfully!';
    } elseif (isset($_POST['delete'])) {
        // Delete product logic
        // $query = "DELETE FROM products WHERE id='$prod_id'";
        // mysqli_query($db_connection, $query);

        $message = 'Product deleted successfully!';
    }
}

// Handle GET requests for initial data
$order_id = $_GET['order_id'] ?? 'Unknown';
$products = $_GET['product'] ?? 'Unknown';
$prices = $_GET['price'] ?? '0';
$quantities = $_GET['quantity'] ?? 'Unknown';
$order_datetime = $_GET['order_datetime'] ?? 'Unknown';
$customer = $_GET['customer'] ?? 'Unknown';
$delv_address = $_GET['delv_address'] ?? 'Unknown';
$amount = $_GET['amount'] ?? '0';

$transact_mode = $_GET['transact_mode'] ?? 'Unknown';
$transact_date = $_GET['transact_date'] ?? 'Unknown';
$transact_amount = $_GET['transact_amount'] ?? '0';
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly Ltd</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/orderDetails.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include "./components/sidebar.php" ?>
        <div class="main-content">
            <?php include "./components/header.php" ?>
            <p class="page-type-banner">order</p>
            <div class="order-header">
                <h2><?php echo htmlspecialchars($order_id); ?></h2>
                <button class="delete-button">Delete</button>
            </div>
            <p class="order-stats">August 06, 2022 | 8:12 pm | 2 items | <span class="advance-paid">Advance paid</span></p>

            <div class="first-order-body">
                <div class="items-section">
                    <h3 style="display: inline-block; margin-top: 10px">Items</h3>
                    <a href="#" class="edit-items"><i class="fa-solid fa-pen" style="color: #000000;"></i></a>
                    <table>
                        <tr>
                            <td><a href="#">#WE15936</a></td>
                            <td>Library stool chair</td>
                            <td>168.90</td>
                            <td>*1</td>
                            <td>168.90</td>
                        </tr>
                        <tr>
                            <td><a href="#">#ZA15937</a></td>
                            <td>Sleeping chair</td>
                            <td>198.90</td>
                            <td>*1</td>
                            <td>198.90</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="subtotal">Subtotal</td>
                            <td>367.80</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="delivery">Delivery charges</td>
                            <td>5.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="total">Total(Rs)</td>
                            <td>352.80</td>
                        </tr>
                    </table>
                </div>
            
                <div style="display: inline">
                    <div class="customer-section">
                        <h3 style="display: inline-block; margin-top: 0px">Customer</h3>
                        <a href="#" style="margin-left: 55%" class="edit-button"><i class="fa-solid fa-pen" style="color: #000000;"></i></a>
                        <div class="customer-info">
                            <img src="./images/user-pic.jpg" alt="custmr-img">
                            <div>
                                <p style="margin-bottom: 5px">Mike James Willis</p>
                                <a href="mailto:mikee.willis@wowmail.com">mikee.willis@wowmail.com</a>
                                <p style="color: #707070; font-size: 12px; margin-bottom: 0px">#WE15936541</p>
                            </div>
                        </div>
                    </div>
                    <div class="delivery-address-section">
                        <h3 style="display: inline-block; margin-top: 0px">Delivery address</h3>
                        <a href="#" class="edit-address"><i class="fa-solid fa-pen" style="color: #000000;"></i></a>
                        <p style="color: #707070; margin-top: 0; margin-bottom:0px; margin-left: 5px; font-size: small;">MJ Willis,<br>35, Red Mosque street,<br>Colombo 11.</p>
                    </div>
                </div>
            </div>
            <div class="second-order-body"></div>
                <div class="transactions-section">
                    <h3 style="margin-top: 8px; margin-bottom:15px; display: inline-block">Transactions</h3>
                    <a href="#" class="edit-button"><i class="fa-solid fa-pen" style="color: #000000;"></i></a>
                    <div class="transaction">
                        <p>Advance payments</p>
                        <p>August 06, 2022</p>
                        <p><span></span>Rs.100.00</p>
                        <a href="#" class="delete-transaction"><i class="fa-solid fa-trash-can" style="color: #000000;"></i></a>
                    </div>
                    <p style="margin-top: 0px; margin-left: 5px; margin-bottom:0px; font-size:smaller; color:#707070">via debit card</p>
                </div>
                <div class="balance-section">
                    <h3 style="margin-top: 8px">Balance</h3>
                    <table class="balance-table">
                        <tr>
                            <td>Order Total</td>
                            <td>$352.80</td>
                        </tr>
                        <tr>
                            <td>Paid by the customer</td>
                            <td>-$100.00</td>
                        </tr>
                        <tr style="border-top: 1px #e2d0c7 solid">
                            <td>Remaining balance</td>
                            <td>$252.80</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
