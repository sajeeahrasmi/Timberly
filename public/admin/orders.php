<?php 
$orders = [
    ['id' => '#QA123', 'date' => 'July 06, 2023', 'product' => 'Table', 'customer' => 'John Doe', 'payType' => 'Null', 'orderStatus' => 'Not confirmed'],
    ['id' => '#WE789', 'date' => 'April 01, 2023', 'product' => 'Chair', 'customer' => 'Mitchell Stark', 'payType' => 'Credit card', 'orderStatus' => 'Awaiting contact designer'],
    ['id' => '#ZS456', 'date' => 'March 30, 2023', 'product' => 'Cupboard', 'customer' => 'Mike Willis', 'payType' => 'Cash', 'orderStatus' => 'Preparing'],
    ['id' => '#AX753', 'date' => 'February 28, 2023', 'product' => 'Table', 'customer' => 'John Doe', 'payType' => 'Cash', 'orderStatus' => 'Delivered']
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
        <script src="./scripts/orders.js"></script>
    </head>
    <body>
        <div class="main-content">
            <div class="orders-display-box">
                <h2>Customer Orders</h2>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Customer name</th>
                            <th>Payment type</th>
                            <th>Order status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['date']); ?></td>
                            <td><?php echo htmlspecialchars($order['product']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer']); ?></td>
                            <td><?php echo htmlspecialchars($order['payType']); ?></td>
                            <td class="order-status"><?php echo htmlspecialchars($order['orderStatus']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>