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
                
                <p><strong>Delivery Fee:</strong> <input type="number" id="deliveryFee" value="<?php echo $item['deliveryFee']; ?>" min="0" step="0.1" onchange="updateTotal()"></p>
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
        <button type="submit">Assign Driver</button>
    </form>
    <div class="assignment-details">
        Please select a driver to assign to the task.
    </div>
</div>
</div>
<script>
// Modify your window.onload function
// Modify your window.onload function to display more driver details
window.onload = function() {
    // Get the assigned driver ID from hidden input
    const assignedDriverId = document.getElementById('assignedDriverId').value;
    const driverStatusDiv = document.querySelector('.assignment-details');
    const driverSelect = document.querySelector('.driver-select');
    
    // First, fetch available drivers for the dropdown
    fetch('../../api/getAvailableDrivers.php')
        .then(response => response.json())
        .then(drivers => {
            // Populate the dropdown with available drivers
            driverSelect.innerHTML = '<option value="">Select Available Driver</option>';
            drivers.forEach(driver => {
                const option = document.createElement('option');
                option.value = driver.driverId;
                option.textContent = `Driver ${driver.driverId} - Vehicle: ${driver.vehicleNo}`;
                
                // If this driver is already assigned, select it
                if (driver.driverId == assignedDriverId) {
                    option.selected = true;
                }
                
                driverSelect.appendChild(option);
            });
            
            // If a driver is already assigned, fetch and display detailed driver information
            if (assignedDriverId && assignedDriverId !== '') {
                fetch(`../../api/driverDetails.php?driverId=${assignedDriverId}`)
                    .then(response => response.json())
                    .then(driverData => {
                        if (driverData.status === 'success') {
                            // Create a formatted HTML display for driver details
                            const driverInfo = `
                                <div class="driver-info">
                                    <h4>Assigned Driver</h4>
                                    <p><strong>Name:</strong> ${driverData.driver.name || 'N/A'}</p>
                                    <p><strong>Phone:</strong> ${driverData.driver.phone || 'N/A'}</p>
                                    <p><strong>Vehicle:</strong> ${driverData.driver.vehicleNo || 'N/A'}</p>
                                    
                                </div>
                            `;
                            
                            driverStatusDiv.innerHTML = driverInfo;
                            
                            // Disable the dropdown and button since a driver is already assigned
                            driverSelect.disabled = true;
                            document.querySelector('.driver-form button[type="submit"]').disabled = true;
                        } else {
                            // Basic fallback if we can't get detailed information
                            driverStatusDiv.textContent = `Driver #${assignedDriverId} is assigned to this order.`;
                            driverStatusDiv.style.color = '#4CAF50';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching driver details:', error);
                        driverStatusDiv.textContent = `Driver #${assignedDriverId} is assigned, but details couldn't be loaded.`;
                        driverStatusDiv.style.color = '#FFA500'; // Orange warning color
                    });
            }
        })
        .catch(error => {
            console.error('Error fetching drivers:', error);
            driverStatusDiv.textContent = 'Error loading drivers. Please try again.';
            driverStatusDiv.style.color = '#f44336';
        });
};

// Update the assignDriver function to also display driver details when newly assigned
function assignDriver() {
    const driverSelect = document.querySelector('.driver-form select');
    const driverStatusDiv = document.querySelector('.assignment-details');
    const selectedDriverId = driverSelect.value;
    const orderId = document.getElementById('orderId').value;
    const itemId = document.getElementById('itemId').value;
    const type = document.getElementById('orderType').value;
    
    if (!selectedDriverId) {
        driverStatusDiv.textContent = 'Please select a driver';
        driverStatusDiv.style.color = '#f44336';
        return;
    }

    fetch('../../api/selectDriver.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `driverId=${selectedDriverId}&orderId=${orderId}&itemId=${itemId}&type=${type}`
    })
    .then(res => res.json())
    .then(response => {
        if (response.status === 'success') {
            // After successful assignment, fetch and display driver details
            fetch(`../../api/getDriverDetails.php?driverId=${selectedDriverId}`)
                .then(response => response.json())
                .then(driverData => {
                    if (driverData.status === 'success') {
                        // Create a formatted HTML display for driver details
                        const driverInfo = `
                            <div class="driver-info">
                                <h4>Assigned Driver</h4>
                                <p><strong>Name:</strong> ${driverData.driver.name || 'N/A'}</p>
                                <p><strong>Phone:</strong> ${driverData.driver.phone || 'N/A'}</p>
                                <p><strong>Vehicle:</strong> ${driverData.driver.vehicleNo || 'N/A'}</p>
                                <p><strong>Status:</strong> <span class="status-active">Active</span></p>
                            </div>
                        `;
                        
                        driverStatusDiv.innerHTML = driverInfo;
                    } else {
                        driverStatusDiv.textContent = `Driver #${selectedDriverId} assigned successfully.`;
                        driverStatusDiv.style.color = '#4CAF50';
                    }
                })
                .catch(error => {
                    console.error('Error fetching driver details:', error);
                    driverStatusDiv.textContent = `Driver #${selectedDriverId} assigned, but details couldn't be loaded.`;
                    driverStatusDiv.style.color = '#FFA500'; // Orange warning color
                });
                
            // Disable the dropdown and button
            driverSelect.disabled = true;
            document.querySelector('.driver-form button[type="submit"]').disabled = true;
        } else {
            driverStatusDiv.textContent = response.message || 'Error assigning driver.';
            driverStatusDiv.style.color = '#f44336';
        }
    })
    .catch(error => {
        console.error('Error assigning driver:', error);
        driverStatusDiv.textContent = 'Error connecting to server. Please try again.';
        driverStatusDiv.style.color = '#f44336';
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
