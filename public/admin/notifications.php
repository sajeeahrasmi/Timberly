<?php
include '../../api/auth.php'; // adjust the path if needed
include '../../api/db.php'; // adjust the path if needed
// Fetch completed orders
$query = "SELECT * FROM orders WHERE status = 'completed'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching order data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Notifications</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/orders.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                padding: 10px;
                border: 1px solid #ccc;
            }

            th {
                background-color: #eee;
            }

            .message {
                margin-top: 20px;
                font-weight: bold;
                color: #B18068;
            }
        </style>
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div class="orders-display-box" style="margin-left: 15px">
                    <h2>Notifications</h2>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['orderId']) ?></td>
                                    <td><?= htmlspecialchars($order['userId'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($order['totalAmount'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($order['category']) ?></td>
                                    <td><?= htmlspecialchars($order['date'] ?? '') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <p class="message">No new notifications</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>