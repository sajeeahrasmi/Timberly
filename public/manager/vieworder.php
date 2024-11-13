<?php
    include '../../api/viewOrderDetails.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order #<?php echo htmlspecialchars($order['id']); ?></title>
    <link rel="stylesheet" href="./styles/vieworder.css">
    <script src="./scripts/vieworder.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <h1 id="header">Order #<?php echo htmlspecialchars($order['id']); ?></h1>
        <button class = "track-order-btn" onclick = "goToOrders()">Back</button>
        <div class="order-details">
            <div class="order-info">
                <h2>Order Information</h2>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($order['date']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                <p><strong>Total:</strong> Rs.<?php echo number_format($order['total'], 2); ?></p>
            </div>
            
            <div class="customer-info">
                <h2>Customer Information</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($customer['address']); ?></p>
            </div>
        </div>
        
        <h2>Order Items</h2>
        <div class="order-items">
            <?php foreach ($orderItems as $item): ?>
                <div class="item">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <div class="item-details">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                        <p>Price: Rs.<?php echo number_format($item['price'], 2); ?></p>
                        <p>Status: <?php echo htmlspecialchars($item['status']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <a href="Trackorder.php?id=5002" class="track-order-btn">Track Order</a>
    </div>
</body>
</html>



