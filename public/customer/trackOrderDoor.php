<?php

session_start();

$itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$query = "SELECT * FROM ordercustomizedfurniture  WHERE itemId = ? AND orderId = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $itemId, $orderId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$orderId = $row['orderId'] ?? '0';
$itemId = $row['itemId'] ?? '0';
$type = $row['type'] ?? '';
$qty = $row['qty'] ?? '0';
$category = $row['category'] ?? '';
$details = $row['details'] ?? '';
$unitPrice = $row['unitPrice'] ?? '0';
$status = $row['status'] ?? '0';
$driverId = $row['driverId'] ?? '0';
$deliveryDate = $row['date'] ?? '';
$reviewId = $row['reviewId'] ?? '0';
$length = $row['length'] ?? '0';
$width = $row['width'] ?? '0';
$thickness = $row['thickness'] ?? '0';
$image = $row['image'] ?? '../images/furniture.jpg';


$query2 = "SELECT name, phone, vehicleNo FROM user JOIN driver ON driver.driverId = user.userId WHERE user.userId = ? ";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $driverId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$name = $row2['name'] ?? '';
$phone = $row2['phone'] ?? '';
$vehicleNo = $row2['vehicleNo'] ?? '';

$query3 = "SELECT * FROM orders WHERE orderId = ? ";
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("i", $orderId);
$stmt3->execute();
$result3 = $stmt3->get_result();
$row3 = $result3->fetch_assoc();
$orderStatus = $row3['status'] ?? '';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Door/Window Track</title>

    <link rel="stylesheet" href="../customer/styles/trackOrderDetails.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/trackDoorOrder.js" defer></script>
   

</head>

<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">  
                
                <div class="item-detail">
                    
                        <h2>Order #<?php echo $orderId ?></h2>
                        <h3>Item #<?php echo $itemId ?></h3>
                    
                    <div class="item-container">
                        <div class="item-image">
                            <img src="<?php echo $image ?>" alt="Item Image">
                        </div>
                        <div class="item-info">
                        <p><strong>Category:</strong> <?php echo $category ?></p>
                            <p><strong>Type of Wood:</strong> <?php echo $type ?></p>
                            <p><strong>Dimension:</strong> <?php echo $length ?> m x <?php echo $width ?> mm x <?php echo $thickness ?> mm</p>
                            <p><strong>Additional Details:</strong> <?php echo $details ?></p>
                            <p><strong>Quantity:</strong> <?php echo $qty ?></p>
                            <p><strong>Price:</strong> Rs. <?php echo $unitPrice ?></p>
                            <p><strong>Status:</strong> <span id="item-status" class="status-badge pending"><?php echo $status ?></span></p>
                            <p><strong>Order Status:</strong> <span id="item-order-status" ><?php echo $orderStatus ?></span></p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button id="edit-btn" class="button outline" disabled>Edit Item</button>
                        <button id="contact-designer-btn" class="button outline"  onclick="designer(<?php echo $itemId ?>, <?php echo $orderId ?>)" disabled>Contact Designer</button>
                        <button id="view-location-btn" class="button outline" disabled>Delivery Detail</button>
                        <button id="leave-review-btn" class="button outline" disabled>Leave Review</button>
                    </div>
                </div>
                
              
                               
                
                
            </div>
        </div>
   
    </div>

    <div id="overlay" class="overlay" onclick="closePopup()"></div>
    <div id="edit-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Edit Item Details</h2>
           
               <div class="form-group">
                    <label for="type">Wood Type: </label>
                    <select id="edit-type">
                        <option value="Jak">Jak</option>
                        <option value="Mahogany">Mahogany</option>
                        <option value="Teak">Teak</option>
                        <option value="Nedum">Nedum</option>
                        <option value="Sooriyamaara">Sooriyamaara</option>
                    </select>
                </div>
                <script>
                    document.getElementById("edit-type").value = "<?php echo $type ?>"; 
                </script>

                <div class="form-group">
                    <label>Length</label>
                    <input type="number" id="edit-length" min = 1 max = 5 value="<?php echo $length ?>">
                </div>
                <script>
                    document.getElementById("edit-length").value = "<?php echo $length ?>"; 
                </script> 

                <div class="form-group">
                    <label>Width</label>
                    <input type="number" id="edit-width" min = 1 max = 1500 value="<?php echo $width ?>">
                </div>
                <script>
                    document.getElementById("edit-width").value = "<?php echo $width ?>"; 
                </script> 

                <div class="form-group">
                    <label>Thickness</label>
                    <input type="number" id="edit-thickness" min = 1 max = 50 value="<?php echo $thickness ?>">
                </div>
                <script>
                    document.getElementById("edit-thickness").value = "<?php echo $thickness ?>"; 
                </script> 

                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="edit-qty" min = 1 max = 20 value="<?php echo $qty ?>">
                </div>
                <script>
                    document.getElementById("edit-qty").value = "<?php echo $qty ?>"; 
                </script>

                <div class="form-group">
                    <label>Additional Details</label>
                    <textarea id="edit-details"><?php echo $details ?></textarea>
                </div>
                <script>
                    document.getElementById("edit-details").value = "<?php echo $details ?>"; 
                </script>

                <button onclick="updateItem(<?php echo $itemId ?>, <?php echo $orderId ?>)">Update</button>

           
        </div>
    </div>

    <div id="delivery-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Delivery Information</h2>
            <p><strong>Driver Name:</strong> <?php echo $name ?></p>
            <p><strong>Vehicle Number:</strong> <?php echo $vehicleNo ?></p>
            <p><strong>Expected Delivery:</strong> <?php echo $deliveryDate ?></p>
            <p><strong>Contact Number:</strong> <?php echo $phone ?></p>
            <button class="button outline">View Location</button>
        </div>
    </div>

    <div id="review-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Leave a Review</h2>
            <textarea placeholder="Write your review here..." id="review-text"></textarea>
            <button class="btn btn-review" onclick="submitReview(<?php echo $orderId ?>, <?php echo $itemId ?>)">Submit Review</button>
        </div>
    </div>>

</body>


</html>
