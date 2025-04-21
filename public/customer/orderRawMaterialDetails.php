<?php

session_start();

$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$query = "SELECT o.*, l.type, l.unitPrice FROM orderlumber o JOIN lumber l ON o.itemId = l.lumberId WHERE o.orderId = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

$query1 = "SELECT status, totalAmount, itemQty FROM orders WHERE orderId = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $orderId);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$status = $row1['status'] ?? 'Unknown';
$totalAmount = $row1['totalAmount'] ?? '0';
$itemQty = $row1['itemQty'] ?? '0';

echo "<script>console.log('Order Status: " . addslashes($status) . "');</script>";

$query2 = "SELECT SUM(amount) AS amount FROM payment WHERE orderId = ? ";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $orderId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$paidAmount = $row2['amount'] ?? '0';

$balance = $totalAmount - $paidAmount;

$query3 = "SELECT 
    u.name , 
    u.phone , 
    d.vehicleNo, 
    o.driverId, 
    o.date
FROM orderlumber o
JOIN user u ON o.driverId = u.userId
JOIN driver d ON o.driverId = d.driverId
WHERE o.orderId = ? 
AND o.status = 'Completed'
ORDER BY o.date ASC 
LIMIT 1;
";
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("i", $orderId);
$stmt3->execute();
$result3 = $stmt3->get_result();
$row3 = $result3->fetch_assoc();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raw Material Order Details</title>

    <link rel="stylesheet" href="../customer/styles/pendingDoorOrder.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/orderRawMaterialDetails.js" defer></script>



</head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">
                
                <div class="top">
                    <h2 id="orderID">Order #<?php echo $orderId ?></h2>
                    <div class="right-section">
                        <p data-status="Pending" id="status"><?php echo $status ?></p>
                        <button id="action-button" class="button outline" onclick="cancelOrder(<?php echo $orderId ?>)">Cancel Order</button>
                    </div>
                </div>
                

                <div class="middle">
                    <div class="card">
                        <h4>Payment Detail</h4>
                        <p>Total: <span><?php echo $totalAmount ?></span> </p>
                        <p>Paid: <span><?php echo $paidAmount ?></span></p>
                        <p>Balance: <span><?php echo $balance ?></span></p>
                        <button id="pay" class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/customer/payment-details.php?orderId=${<?php echo $orderId ?>}`">Pay</button>
                    </div>
                    <div class="card">
                        <h4>Measurement Person</h4>
                        <p>Name : </p>
                        <p>Date : <input type="date" /></p>
                        <p>Time : </p>
                        <p>Contact : </p>
                        
                    </div>
                    <div class="card">
                        <h4>Delivery Person</h4>
                        <p>Name : <span><?php echo  $row3['name'] ?? '' ?></span></p>
                        <p>Date : <span><?php echo  $row3['date'] ?? '' ?></span>   <input type="date" /></p>
                        <p>Contact : <span><?php echo  $row3['phone'] ?? '' ?></span></p>
                    </div>
                </div>
                

                <div class="bottom">
                    <div class="topic">
                        <h2>Order Details</h2>
                        <p id="noOfItems">No. of Items: <?php echo $itemQty ?></p>
                    </div>

                    <div class="filter-container">
                        <div class="filter">
                            <label for="order-status">Item Status:</label>
                            <select id="order-status" class="filter-select">
                                <option value="">All</option>
                                <option value="Pending">Pending</option>
                                <option value="Declined">Declined</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Processing">Processing</option>
                                <option value="Finished">Finished</option>
                                <option value="Delivered">Delivered</option>
             
                            </select>
                        </div>
                        
                        <div class="filter">
                            <label for="wood-type">Wood Type</label>
                            <select id="wood-type" class="filter-select">
                                <option value="">All</option>
                                <option value="Jak">Jak</option>
                                <option value="Mahogany">Mahogany</option>
                                <option value="Teak">Teak</option>
                                <option value="Sooriyamaara">Sooriyamaara</option>
                                <option value="Nedum">Nedum</option>
                            </select>
                        </div>                    
                        <button id="filter" class="button filter-btn">Filter</button>
                        <button id="addItem" style="margin-left: auto; padding: 8px;" class="button outline" onclick="showPopup()">Add Items</button>
                    </div>
    
                    <div class="table-container">
                        <table class="styled-table" id="orderDetails">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['itemId']); ?></td>
                                        <?php $id = htmlspecialchars($row['itemId']) ?>
                                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['qty']); ?></td>
                                        <td><?php echo htmlspecialchars($row['unitPrice']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td>
                                            <button class="button outline" id="view-button" style="margin-right: 10px; padding: 10px; border-radius: 10px;" onclick="window.location.href=`http://localhost/Timberly/public/customer/trackOrderMaterials.php?itemId=${<?php echo $id ?>}&orderId=${<?php echo $orderId ?>}`">view</button>
                                            <button class="button solid" id="delete-button"  style=" padding: 10px; border-radius: 10px;" onclick="deleteItem(<?php echo $id ?>, <?php echo $orderId ?>, <?php echo $userId ?>)">delete</button>                                            
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

    <div id="overlay" class="overlay" ></div>
    <div id="popup" class="popup">
        <div class="form-content">
            <h4>Item Details</h4>
            <form>
                <div class="form-group">
                    <label for="type">Raw Material Type: </label>
                    <select id="type" name="type" onchange="updateLengths()">
                        <option value="">--Select Type--</option>
                        <option value="Jak">Jak</option>
                        <option value="Mahogany">Mahogany</option>
                        <option value="Teak">Teak</option>
                        <option value="Teak">Sooriyamaara</option>
                        <option value="Teak">Nedum</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <h5>Size</h5>
                    <label for="length">Length (m):</label>
                    <select id="length" name="length" onchange="updateWidths()">
                        <option value="">--Select Length--</option>
                    </select><br><br>
                    <label for="width">Width (mm):</label>
                    <select id="width" name="width" onchange="updateThicknesses()">
                        <option value="">--Select Width--</option>
                    </select>
                    <br><br>
                    <label for="thickness">Thickness (mm):</label>
                    <select id="thickness" name="thickness" onchange="updateQty()">
                        <option value="">--Select Thickness--</option>
                    </select>
                </div>
                

                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="qty" name="qty" min="1" value="1">
                </div>
                
                <div class="form-group">
                    <label id="price" >Unit Price:</label>
                    
                </div>

            </form>
            <div class="add-button">
                <button type="submit" class="button outline" onclick="closePopup(<?php echo $userId ?>, <?php echo $orderId ?>)">Add Item</button>
                <button id="close-popup" class="button solid" onclick="close()">Close</button>
            </div>
            
        </div>
    </div>


    
    

</body>
</html>
