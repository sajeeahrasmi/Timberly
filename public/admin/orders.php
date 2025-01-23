<?php 
$orders = [
    ['order_id' => '#QA123', 'date' => 'July 06, 2023', 'customer' => 'John Doe', 'amount' => '9600.00', 'payType' => 'Null', 'orderStatus' => 'Not confirmed'],
    ['order_id' => '#WE789', 'date' => 'April 01, 2023', 'customer' => 'Mitchell Stark', 'amount' => '5200.00', 'payType' => 'Credit card', 'orderStatus' => 'Awaiting contact designer'],
    ['order_id' => '#ZS456', 'date' => 'March 30, 2023', 'customer' => 'Mike Willis', 'amount' => '91000.00', 'payType' => 'Cash', 'orderStatus' => 'Preparing'],
    ['order_id' => '#AX753', 'date' => 'February 28, 2023', 'customer' => 'John Doe', 'amount' => '1000.00', 'payType' => 'Cash', 'orderStatus' => 'Delivered']
];
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/orders.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div class="orders-display-box">
                    <h2>Customer Orders</h2>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer name</th>
                                <th class="order-amount">Amount(Rs)</th>
                                <th>Payment type</th>
                                <th>Order status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr onclick="window.location.href='./orderDetails.php?order_id=<?php echo urlencode($order['order_id']); ?>'">
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['date']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer']); ?></td>
                                <td class="order-amount"><?php echo htmlspecialchars($order['amount']); ?></td>
                                <td><?php echo htmlspecialchars($order['payType']); ?></td>
                                <td class="order-status"><?php echo htmlspecialchars($order['orderStatus']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <script src="./scripts/orders.js"></script>
</html>