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


// $query2 = "SELECT amount FROM payment WHERE orderId = ? ";
// $stmt2 = $conn->prepare($query2);
// $stmt2->bind_param("i", $orderId);
// $stmt2->execute();
// $result2 = $stmt2->get_result();
// $row2 = $result2->fetch_assoc();
// $paidAmount = $row2['amount'] ?? '0';

// $balance = $totalAmount - $paidAmount;

// $query3 = "SELECT 
//     u.name , 
//     u.phone , 
//     d.vehicleNo, 
//     o.driverId, 
//     o.date
// FROM orderfurniture o
// JOIN user u ON o.driverId = u.userId
// JOIN driver d ON o.driverId = d.driverId
// WHERE o.orderId = ? 
// AND o.status = 'Completed'
// ORDER BY o.date ASC 
// LIMIT 1;
// ";
// $stmt3 = $conn->prepare($query3);
// $stmt3->bind_param("i", $orderId);
// $stmt3->execute();
// $result3 = $stmt3->get_result();
// $row3 = $result3->fetch_assoc();

// $query4 = "SELECT * FROM furnitures";
// $result4 = mysqli_query($conn, $query4);
// $furnitureData = [];
// while ($row4 = mysqli_fetch_assoc($result4)) {
//     $furnitureData[] = $row4;
// }

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
                            <p><strong>Description:</strong> <?php echo $description ?></p>
                            <p><strong>Type of Wood:</strong> <?php echo $type ?></p>
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
            <form>
                <!-- <div class="form-group">
                    <label>Wood Type</label>
                    <input type="text" id="edit-type" value="<?php echo $type ?>">
                </div> -->
                <div class="form-group">
                    <label for="type">Wood Type: </label>
                    <select id="type">
                        <option value="Jak">Jak</option>
                        <option value="Mahogany">Mahogany</option>
                        <option value="Teak">Teak</option>
                        <option value="Nedum">Nedum</option>
                        <option value="Sooriyamaara">Sooriyamaara</option>
                    </select>
                </div>
                <script>
                    document.getElementById("type").value = "<?php echo $type ?>"; // Sets selected option dynamically
                </script>

                <div class="form-group">
                    <label>Size</label>
                    <input type="text" id="edit-size" value="<?php echo $size ?>">
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="edit-qty" min = 0 max = 20 value="<?php echo $qty ?>">
                </div>
                <div class="form-group">
                    <label>Additional Details</label>
                    <textarea id="edit-details"><?php echo $details ?></textarea>
                </div>
            </form>
        </div>
    </div>

    <div id="delivery-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Delivery Information</h2>
            <p><strong>Driver Name:</strong> John Doe</p>
            <p><strong>Vehicle Number:</strong> TRK-5678</p>
            <p><strong>Expected Delivery:</strong> June 15, 2024</p>
            <p><strong>Contact Number:</strong> +1 (555) 123-4567</p>
            <button class="button outline">View Location</button>
        </div>
    </div>

    <div id="review-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Leave a Review</h2>
            <div class="star-rating">
                <span class="star" data-rating="1">★</span>
                <span class="star" data-rating="2">★</span>
                <span class="star" data-rating="3">★</span>
                <span class="star" data-rating="4">★</span>
                <span class="star" data-rating="5">★</span>
            </div>
            <textarea placeholder="Write your review here..." rows="4"></textarea>
            <button class="btn btn-review">Submit Review</button>
        </div>
    </div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const status = document.getElementById("item-status").textContent;
    const editBtn = document.getElementById("edit-btn");
    const contactDesignerBtn = document.getElementById("contact-designer-btn");
    const viewLocationBtn = document.getElementById("view-location-btn");
    const leaveReviewBtn = document.getElementById("leave-review-btn");

    const popups = {
                edit: document.getElementById('edit-popup'),
                delivery: document.getElementById('delivery-popup'),
                review: document.getElementById('review-popup')
            };

    function updateButtonsBasedOnStatus(status) {
        // Reset buttons
        editBtn.disabled = true;
        viewLocationBtn.disabled = true;
        leaveReviewBtn.disabled = true;

        if (status === "Pending" || status === "Confirmed") {
            editBtn.disabled = false;
            
        } else if (status === "Delivering") {
            viewLocationBtn.disabled = false;
        } else if (status === "Completed") {
            leaveReviewBtn.disabled = false;
        }
    }

    // Update buttons on page load
    updateButtonsBasedOnStatus(status);

    editBtn.addEventListener('click', () => openPopup(popups.edit));

    // Example: Handle location view
    viewLocationBtn.addEventListener('click', () => openPopup(popups.delivery));

    // Example: Handle review
    leaveReviewBtn.addEventListener('click', () => openPopup(popups.review));

    function closePopup(popup) {
                popup.style.display = 'none';
                document.getElementById("overlay").style.display = "none";
            }

            // Open popup function
            function openPopup(popup) {
                document.getElementById("overlay").style.display = "block";
                popup.style.display = 'flex';
            }

            // Add close event to all popups
            document.querySelectorAll('.popup-close').forEach(closeBtn => {
                closeBtn.addEventListener('click', (e) => {
                    closePopup(e.target.closest('.popup'));
                });
            });
});

        

         

</script>
</html>
