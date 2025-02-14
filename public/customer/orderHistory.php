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

$query = "SELECT * FROM orders WHERE userId = ? ORDER BY date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../customer/styles/orderHistory.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/orderHistory.js" defer></script>
</head>
<body>
    <div class="dashboard-container">
        <div id="sidebar"></div>
        <div class="main-content">
            <div id="header"></div>
            <div class="content">  
                <div class="top">
                    <h2>Order History</h2>
                    <h3>Total no.of orders : <?php echo $result->num_rows; ?></h3>
                </div>
                <div class="filter-container">
                    <label for="order-status">Order Status:</label>
                    <select id="order-status" class="filter-select">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Processing">Processing</option>
                        <option value="Completed">Completed</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                    <label for="payment-status">Payment Status:</label>
                    <select id="payment-status" class="filter-select">
                        <option value="">All</option>
                        <option value="Paid">Paid</option>
                        <option value="Unpaid">Unpaid</option>
                        <option value="Partially_Paid">Partially Paid</option>
                    </select>
                    <label for="order-category">Order Category:</label>
                    <select id="order-category" class="filter-select">
                        <option value="">All</option>
                        <option value="CustomisedFurniture">Door/Window</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Lumber">Lumber</option>
                    </select>
                    <button class="button filter-btn" id="filter">Filter</button>
                </div>
                <div class="bottom">
                    <div class="table-container">
                        <table class="styled-table" id="orderDetails">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>No. of Items</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Order Status</th>
                                    <th>Total Amount</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['orderId']); ?></td>
                                        <td><?php echo htmlspecialchars($row['itemQty']); ?></td>
                                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td><?php echo htmlspecialchars($row['totalAmount']); ?></td>
                                        <td><?php echo htmlspecialchars($row['paymentStatus']); ?></td>
                                        <td>
                                            <button class="button outline" id="view-button">view</button>                                            
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
