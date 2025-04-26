<?php

require_once '../../api/auth.php';


include '../../api/trackorderdetails.php';


 
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
<input type="hidden" id="orderId" value="<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>">
<input type="hidden" id="itemId" value="<?php echo htmlspecialchars($orderDetails[0]['itemId'] ?? ''); ?>">
<input type="hidden" id="assignedDriverId" value="<?php echo htmlspecialchars($orderDetails[0]['driverId'] ?? ''); ?>">

<input type="hidden" id="orderType" value="<?php echo htmlspecialchars($orderDetails[0]['orderType'] ?? ''); ?>">

<div class="header">
        <div class="container">
            <h1 id="orderTitle">Order #<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? 'N/A'); ?></h1>
        </div>
    </div>
    <div class="container">
        <div class="progress-container">
            <div class="progress-bar" id="progressBar">0%</div>
        </div>
      
        <div class="button-container">
            <button onclick="updateStatus('Confirmed','<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>','<?php echo htmlspecialchars($orderDetails[0]['itemId'] ?? ''); ?>')">Confirm</button>
            <button onclick="updateStatus('Processing','<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? '' ); ?>' ,'<?php echo htmlspecialchars($orderDetails[0]['itemId'] ?? ''); ?>')">Processing</button>
            <button onclick="updateStatus('Not_Delivered','<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>','<?php echo htmlspecialchars($orderDetails[0]['itemId'] ?? ''); ?>')">Ready to Deliver</button>
            <button onclick="updateStatus('Delivered','<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>','<?php echo htmlspecialchars($orderDetails[0]['itemId'] ?? ''); ?>')">Delivered</button>
            <button onclick="updateStatus('Completed','<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>','<?php echo htmlspecialchars($orderDetails[0]['itemId'] ?? ''); ?>')">Completed</button>
        </div>
        <button class="back-btn" onclick="window.location.href = 'admin.php';">← Back</button>

        <div class="main-content">
            <div class="order-details">
            <h2>Order Details</h2>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Unit Price</th>
                </tr>
                <?php foreach ($orderDetails as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['typeQty'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($item['itemStatus'] ?? 'N/A'); ?></td>
                        <td>
                            <input type="number" id = 'qty' value="<?php echo $item['qty']; ?>" min="1" >
                        </td>
                        <td>Rs.<?php echo number_format($item['unitPrice'] * $item['qty'], 2); ?></td>
                        <td>Rs.<?php echo number_format($item['unitPrice'] ?? 0); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="order-summary">
                <h3>Order Summary</h3>
                
                <p><strong>Delivery Fee:</strong> <input type="number" id="deliveryFee" value="<?php echo $item['deliveryFee'] ?? 0; ?>" min="0" step="0.1" onchange="updateTotal()"></p>
                <p><strong>Total:</strong> Rs.<span id="total">0.00</span></p>
            </div>
                <button class="update-total" onclick="updateTotal()">Update Total</button>
                
            </div>
            
            <div class="card-container">
                <div class="card">
                <h3>Measurement Person Details</h3>
<p>Name: <?php echo htmlspecialchars($item['measurerName'] ?? 'N/A'); ?></p>
<p>Arrival Date: <?php echo !empty($item['measurementDate']) ? htmlspecialchars($item['measurementDate']) : 'Not scheduled'; ?></p>
<p>Arrival Time: <?php echo !empty($item['measurementTime']) ? htmlspecialchars($item['measurementTime']) : 'Not scheduled'; ?></p>
<p>Phone: <?php echo htmlspecialchars($item['measurerContact'] ?? 'N/A'); ?></p>

                    <button onclick="showPopup('measurementPopup')">Update</button>
                </div>
                <div class="card">                            
                <div class="driver-assignment-section">
    <form class="driver-form" onsubmit="event.preventDefault(); assignDriver();">
        <select class="driver-select">
            <option value="">Loading drivers...</option>
        </select>
        <input type="date" id="driverDate" placeholder="Select a date" style="margin-top: 10px; padding: 5px; width: 30%;">

        <button type="submit">Assign Driver</button>
        
    </form>
    <div class="assignment-details">
        Please select a driver to assign to the task.
    </div>
    
</div>
</div>


<div class="card">
    <h3>Payment Details</h3>
    <input type="hidden" id="orderId" value="<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>">
    <p><strong>Amount Paid:</strong> <span id="amountPaid">Rs. 0.00</span></p>
    <button onclick="updatenew()">Update Payment</button>
</div> 

            </div>
    
        </div>
    
    </div>
    
    <div id="measurementPopup" class="popup" >
        <div class="popup-content">
            <h3>Update Measurement Person Details</h3>
            <input type="hidden" id="orderId" value="<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>">
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
