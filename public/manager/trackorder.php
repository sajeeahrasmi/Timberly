<?php
// Authentication check
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
                        <td><?php echo htmlspecialchars($item['typeQty']); ?></td>
                        <td><?php echo htmlspecialchars($item['itemStatus']); ?></td>
                        <td>
                            <input type="number" id = 'qty' value="<?php echo $item['qty']; ?>" min="1" >
                        </td>
                        <td>Rs.<?php echo number_format($item['unitPrice'] * $item['qty'], 2); ?></td>
                        <td>Rs.<?php echo number_format($item['unitPrice']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="order-summary">
                <h3>Order Summary</h3>
                
                <p><strong>Delivery Fee:</strong> <input type="number" value="100" min="0" step="0.1" onchange="updateTotal()"></p>
                <p><strong>Total:</strong> Rs.<span id="total">0.00</span></p>
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
                <div class="driver-assignment-section">
    <form class="driver-form" onsubmit="event.preventDefault(); assignDriver();">
        <select class="driver-select">
            <option value="">Loading drivers...</option>
        </select>
        <button type="submit">Assign Driver</button>
    </form>
    <div class="assignment-details">
        Please select a driver to assign to the task.
    </div>
</div>
</div>
<script>
window.onload = function() {
    fetch('../../api/getAvailableDrivers.php')
        .then(response => response.json())
        .then(drivers => {
            const select = document.querySelector('.driver-select');
            select.innerHTML = '<option value="">Select Available Driver</option>';
            drivers.forEach(driver => {
                const option = document.createElement('option');
                option.value = driver.driverId;
                option.textContent = `Driver ${driver.driverId} - Vehicle: ${driver.vehicleNo}`;
                select.appendChild(option);
            });
        });
};

function assignDriver() {
    const driverSelect = document.querySelector('.driver-form select');
    const driverStatusDiv = document.querySelector('.assignment-details');
    const selectedDriverId = driverSelect.value;
    const orderId = '<?php echo htmlspecialchars($orderDetails[0]['orderId'] ?? ''); ?>';
    //trim the orderId to remove any extra spaces
    
     // Fallback to 0 if orderId is not available
    if (!selectedDriverId) {
        driverStatusDiv.textContent = 'Please select a driver';
        driverStatusDiv.style.color = '#f44336';
        return;
    }

    fetch('../../api/selectDriver.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `driverId=${selectedDriverId}&orderId=${orderId}`
    })
    .then(res => res.json())
    .then(response => {
        driverStatusDiv.textContent = response.message;
        driverStatusDiv.style.color = response.status === 'success' ? '#4CAF50' : '#f44336';
        if (response.status === 'success') {
            driverSelect.disabled = true;
        }
    });
}
</script>

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
