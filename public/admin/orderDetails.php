<?php
// Database connection placeholder
// include('db_connection.php');

// Initialize variables
$message = '';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? '';
    $product = $_POST['product'] ?? '';
    $order_date = $_POST['order_date'] ?? '';
    $order_time = $_POST['order_time'] ?? '';
    $customer = $_POST['customer'] ?? '';
    $del_address = $_POST['del_address'] ?? '';
    $price = $_POST['price'] ?? 0;
    $old_price = $_POST['old_price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $visibility = $_POST['visibility'] ?? 'Hidden';

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
$prod_id = $_GET['prod_id'] ?? 'Unknown';
$date = $_GET['date'] ?? 'Unknown';
$product = $_GET['product'] ?? 'Unknown';
$category = $_GET['category'] ?? 'Unknown';
$price = $_GET['price'] ?? 0;
$availability = $_GET['availability'] ?? 'Unknown';
$quantity = $_GET['quantity'] ?? 0;
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
    <link rel="stylesheet" href="orderEdit.css">
</head>
<body>
    <div class="page-content">
        <div class="main-content">
            <div class="order-header">
                <h2>Order #QA15932</h2>
                <button class="delete-button">Delete</button>
            </div>
            <p>August 06, 2022 | 8:12 pm | 2 items | <span class="advance-paid">Advance paid</span></p>

            <div class="order-body">
                <div class="items-section">
                    <h3>Items</h3>
                    <table class="items-table">
                        <tr>
                            <td><a href="#">#WE15936</a></td>
                            <td>Library stool chair</td>
                            <td>$168.90</td>
                            <td>*1</td>
                            <td>$168.90</td>
                        </tr>
                        <tr>
                            <td><a href="#">#ZA15937</a></td>
                            <td>Sleeping chair</td>
                            <td>$198.90</td>
                            <td>*1</td>
                            <td>$198.90</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="subtotal">Subtotal</td>
                            <td>$367.80</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="delivery">Delivery charges</td>
                            <td>$5.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="total">Total</td>
                            <td>$352.80</td>
                        </tr>
                    </table>
                    <a href="#" class="edit-items">Edit items</a>
                </div>

                <div class="customer-section">
                    <h3>Customer</h3>
                    <div class="customer-info">
                        <img src="../Assets/customerPic.png" alt="Customer">
                        <div>
                            <p>Mike James Willis</p>
                            <a href="mailto:mikee.willis@wowmail.com">mikee.willis@wowmail.com</a>
                            <p>#WE15936541</p>
                        </div>
                    </div>
                    <a href="#" class="edit-customer">Edit</a>

                    <h3>Delivery address</h3>
                    <p>MJ Willis,<br>35, Red Mosque street,<br>Colombo 11.</p>
                    <a href="#" class="edit-address">Edit</a>
                </div>

                <div class="transactions-section">
                    <h3>Transactions</h3>
                    <div class="transaction">
                        <p>Advance payments from the Debit card</p>
                        <p>August 06, 2022</p>
                        <p>$100.00</p>
                        <button class="delete-transaction">🗑️</button>
                    </div>
                    <a href="#" class="add-transaction">Add transaction</a>

                    <h3>Balance</h3>
                    <table class="balance-table">
                        <tr>
                            <td>Order Total</td>
                            <td>$352.80</td>
                        </tr>
                        <tr>
                            <td>Paid by the customer</td>
                            <td>-$100.00</td>
                        </tr>
                        <tr>
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
