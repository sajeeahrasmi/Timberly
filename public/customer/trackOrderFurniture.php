<?php

session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$query = "SELECT * FROM orderfurniture  WHERE id = ?;";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$orderId = $row['orderId'] ?? '0';
$itemId = $row['itemId'] ?? '0';
$type = $row['type'] ?? '0';
$qty = $row['qty'] ?? '0';
$size = $row['size'] ?? '0';
$details = $row['additionalDetails'] ?? '0';
$unitPrice = $row['unitPrice'] ?? '0';
$status = $row['status'] ?? '0';
$driverId = $row['driverId'] ?? '0';
$deliveryDate = $row['date'] ?? '0';
$reviewId = $row['reviewId'] ?? '0';



$query1 = "SELECT * FROM furnitures WHERE furnitureId = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $itemId);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$description = $row1['description'] ?? 'Unknown';
$image = $row1['image'] ?? '../images/furniture.jpg';
$category = $row1['category'] ?? '0';



$query2 = "SELECT name, phone, vehicleNo FROM user JOIN driver ON driver.driverId = user.userId WHERE user.userId = ? ";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $driverId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$name = $row2['name'] ?? '';
$phone = $row2['phone'] ?? '';
$vehicleNo = $row2['vehicleNo'] ?? '';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture track</title>

    <link rel="stylesheet" href="../customer/styles/trackOrderDetails.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/trackFurnitureOrder.js" defer></script>

   

</head>

<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">  
                
                <div class="item-detail">
                        <h2>Order #<?php echo $orderId ?></h2>
                        <h3 >Item #<?php echo $id ?></h3>

                    <div class="item-container">
                        <div class="item-image">
                            <img src="<?php echo $image ?>" alt="Item Image">
                        </div>
                        <div class="item-info">
                            <p><strong>Description:</strong> <?php echo $description ?></p>
                            <p><strong>Type of Wood:</strong> <?php echo $type ?></p>
                            <p><strong>Size:</strong> <?php echo $size ?></p>
                            <p><strong>Additional Details:</strong> <?php echo $details ?></p>
                            <p><strong>Quantity:</strong> <?php echo $qty ?></p>
                            <p><strong>Price:</strong> Rs. <?php echo $unitPrice ?></p>
                            <p><strong>Status:</strong> <span id="item-status" class="status-badge pending"><?php echo $status ?></span></p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button id="edit-btn" class="button outline" disabled>Edit Item</button>
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
                    <label for="size">Wood Size: </label>
                    <select id="edit-size">
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>
                </div>
                <script>
                    document.getElementById("edit-size").value = "<?php echo $size ?>"; 
                </script>

                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="edit-qty" min = 0 max = 20 value="<?php echo $qty ?>">
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

                <button onclick="updateItem(<?php echo $id ?>)">Update</button>

           
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
            <button class="btn btn-review" onclick="submitReview(<?php echo $orderId ?>, <?php echo $id ?>)">Submit Review</button>
        </div>
    </div>

</body>

</html>
