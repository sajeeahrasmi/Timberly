<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';
include '../../api/ViewOrderDetails.php';
// Debug: Print order details (optional)

?>

    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order #<?php echo htmlspecialchars($order['id']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .header-section {
            background-color: #895D47;
            padding: 2rem;
            color: white;
            position: relative;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .header-content h1 {
            text-align: center;
            font-size: 2rem;
        }

        .back-btn {
            position: fixed; 
            top: 20px; 
            left: 20px; 
            background-color: transparent;
            border: 2px solid white;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            margin-left : 0px;
        }

        .back-btn:hover {
            background-color: white;
            color: #895D47;
        }

        .main-content {
            max-width: 1800px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .order-details {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid #895D47;
            width: 100%; /* Ensure it covers the full row */
        }

        .info-card h2 {
            color: #895D47;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            border-bottom: 2px solid #895D47;
            padding-bottom: 0.5rem;
            text-align: center;
        }

        .info-card p {
            margin: 1rem 0;
            font-size: 1.1rem;
        }

        .info-card strong {
            color: #555;
            width: 100px;
            display: inline-block;
        }

        .items-section {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid #895D47;
            width: 100%; /* Ensure it covers the full row */
        }

        .items-section h2 {
            color: #895D47;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            border-bottom: 2px solid #895D47;
            padding-bottom: 0.5rem;
            text-align: center;
        }

        .order-items {
            display: grid;
            gap: 1.5rem;
        }

        .item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1.5rem;
            padding: 1.5rem;
            background-color: #f9f9f9;
            border-radius: 10px;
            transition: transform 0.3s;
            border: 1px solid #895D47;
        }

        .item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(137, 93, 71, 0.2);
        }

        .item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        .item-details {
            display: grid;
            gap: 0.5rem;
        }

        .item-details h3 {
            color: #895D47;
            font-size: 1.2rem;
        }

        .item-details p {
            color: #666;
            font-size: 1rem;
        }

        .track-order-btn {
            display: inline-block;
            background-color: #895D47;
            color: white;
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 2rem;
            transition: all 0.3s;
            border: 2px solid #895D47;
        }

        .track-order-btn:hover {
            background-color: white;
            color: #895D47;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 1rem;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 500;
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #2e7d32;
        }

        @media (max-width: 768px) {
            .order-details {
                flex-direction: column;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .back-btn {
                position: static;
                margin-bottom: 1rem;
            }

            .main-content {
                margin-top: 2rem;
                padding: 0 1rem;
            }

            .item {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .item img {
                margin: 0 auto;
            }

            .info-card {
                width: 100%;
            }

            .header-content h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0 0.5rem;
            }

            .info-card, .items-section {
                padding: 1rem;
            }

            .item {
                padding: 1rem;
            }

            .track-order-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="header-content">
                <button class="back-btn" onclick="goToOrders()">← Back</button>
                <h1>Order #<?php echo htmlspecialchars($orderDetails['orderId']); ?></h1>
            </div>
        </div>

        <div class="main-content">
            <div class="order-details">
                <div class="info-card">
                    <h2>Order Information</h2>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($orderDetails['date']); ?></p>
                    <p><strong>Status:</strong> <span class="status-badge"><?php echo htmlspecialchars($orderDetails['status']); ?></span></p>
                    <p><strong>Total:</strong> Rs.<?php echo number_format($orderDetails['totalAmount'], 2); ?></p>
                </div>
                
                <div class="info-card">
                    <h2>Customer Information</h2>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($orderDetails['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($orderDetails['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($orderDetails['phone']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($orderDetails['address']); ?></p>
                </div>
            </div>
            
            <div class="items-section">
                <h2>Order Items</h2>
                <div class="order-items">
                   
                        <div class="item">
                           
                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($orderDetails['description']); ?></h3>
                                <p>Quantity: <?php echo htmlspecialchars($orderDetails['qty']); ?></p>
                                <p>Price: Rs.<?php echo number_format($orderDetails['unitPrice'], 2); ?></p>
                                <p>Size:<?php echo htmlspecialchars($orderDetails['size']); ?></p>
                                <p>Status: <span class="status-badge"><?php echo htmlspecialchars($orderDetails['status']); ?></span></p>
                            </div>
                        </div>
                  
                </div>
                
                <a href="Trackorder.php?id=<?php echo $orderDetails['orderId']; ?>" class="track-order-btn">Track Order</a>

            </div>
        </div>
    </div>


     
</body>
<script src="./scripts/vieworder.js"></script>
</html>
