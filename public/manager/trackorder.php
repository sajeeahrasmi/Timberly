<?php

        include '../../api/viewOrderDetails.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./styles/trackorder.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1 id="orderTitle">Order #<?php echo htmlspecialchars($order['id']); ?></h1>
        </div>
    </div>
    <div class="container">
        <div class="progress-container">
            <div class="progress-bar" id="progressBar">0%</div>
        </div>
        
        <div class="button-container">
            <button onclick="updateStatus('Confirm')">Confirm</button>
            <button onclick="updateStatus('Processing')">Processing</button>
            <button onclick="updateStatus('Polishing')">Polishing</button>
            <button onclick="updateStatus('Delivering')">Delivering</button>
        </div>
        <button onclick="window.location.href = 'vieworder.php'">Back</button>
        <div class="main-content">
            <div class="order-details">
                <h2>Order Details</h2>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    <?php foreach ($orderItems as $index => $item): ?>
                        <tr id="product-<?php echo $index + 1; ?>">
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td class="status" data-product-id="<?php echo $index + 1; ?>"><?php echo htmlspecialchars($item['status']); ?></td>
                            <td>
                                <input type="number" class="quantity" data-product-id="<?php echo $index + 1; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                            </td>
                            <td>Rs.<?php echo number_format($item['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-item">
                        <span>Subtotal:</span>
                        <span id="subtotal">Rs.<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Delivery fee:</span>
                        <input type="number" id="deliveryFee" value="<?php echo number_format($deliveryFee, 2); ?>" min="0" step="0.01">
                    </div>
                    <div class="summary-item">
                        <strong>Total:</strong>
                        <strong id="total">Rs.<?php echo number_format($total, 2); ?></strong>
                    </div>
                </div>
                <button class="update-total" onclick="updateTotal()">Update Total</button>
            </div>
            <div class="card-container">
                <div class="card">
                    <h3>Measurement Person Details</h3>
                    <p>Name: Saim Ayub</p>
                    <p>Arrival Date: 2023-09-20</p>
                    <p>Arrival Time: 14:00</p>
                    <p>Phone: (123) 456-7890</p>
                    <button onclick="showPopup('measurementPopup')">Update</button>
                </div>
                <div class="card">
                    <h3>Payment Details</h3>
                    <p>Card: **** **** **** 1234</p>
                    <p>Expiry: 12/25</p>
                    <p>Name on Card: John Doe</p>
                </div>
            </div>
        </div>
    </div>
    
    <div id="measurementPopup" class="popup">
        <div class="popup-content">
            <h3>Update Measurement Person Details</h3>
            <input type="text" id="name" placeholder="Name">
            <input type="date" id="arrivalDate">
            <input type="time" id="arrivalTime">
            <input type="text" id="phoneNumber" placeholder="Phone Number">
            <button onclick="updateDetails('measurement')">Update</button>
            <button onclick="closePopup('measurementPopup')">Close</button>
        </div>
    </div>
    <script src="./scripts/trackorder.js"></script>
</body>
</html>
