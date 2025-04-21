<?php

session_start();

$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$query = "SELECT f.description, f.category, o.id, o.type, o.qty, o.size, o.status, o.unitPrice FROM orderfurniture o JOIN furnitures f ON o.itemId = f.furnitureId WHERE o.orderId = ?;";
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
FROM orderfurniture o
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

$query4 = "SELECT * FROM furnitures";
$result4 = mysqli_query($conn, $query4);
$furnitureData = [];
while ($row4 = mysqli_fetch_assoc($result4)) {
    $furnitureData[] = $row4;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Order Details</title>

    <link rel="stylesheet" href="../customer/styles/pendingDoorOrder.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/orderFurnitureDetails.js" defer></script>

    <style>
        .image-dropdown {
            position: relative;
        }
    
        .dropdown {
            display: inline-block;
            position: relative;
        }
    
        .dropdown-toggle {
            cursor: pointer;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            display: inline-block;
        }
    
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 10;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            white-space: nowrap;
        }
    
        .dropdown-menu img {
            cursor: pointer;
            margin: 5px 0;
        }
    
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    
        .dropdown img {
            width: 100px;
            height: auto;
        }
    </style>

</head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">
                
                <div class="top">
                    <h2>Order # <?php echo $orderId ?></h2>
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
                        <p>No. of Items: <?php echo $itemQty ?></p>
                    </div>

                    <div class="filter-container">
                        <div class="filter">
                            <label for="item-status">Item Status:</label>
                            <select id="item-status" class="filter-select">
                                <option value="">All</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Not_Approved">Not Approved</option>
                                <option value="Processing">Processing</option>
                                <option value="Finished">Finished</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                        </div>
                        
                        <div class="filter">
                            <label for="item-category">Category</label>
                            <select id="item-category" class="filter-select">
                                <option value="">All</option>
                                <option value="Chair">Chair</option>
                                <option value="Table">Table</option>
                                <option value="Wardrobe">Wardrobe</option>
                                <option value="Bookshelf">Bookshelf</option>
                                <option value="Stool">Stool</option>
                            </select>
                        </div>         
                        
                        <div class="filter">
                            <label for="item-type">Wood Type</label>
                            <select id="item-type" class="filter-select">
                                <option value="">All</option>
                                <option value="Jak">Jak</option>
                                <option value="Mahogany">Mahogany</option>
                                <option value="Teak">Teak</option>
                                <option value="Nedum">Nedum</option>
                                <option value="Sooriyamaara">Sooriyamaara</option>
                            </select>
                        </div>         

                        <button class="button filter-btn" onclick="filterItems()">Filter</button>

                        <button id="addItem" style="margin-left: auto; padding: 8px;" class="button outline" onclick="showPopup()">Add Items</button>
                    </div>
    
                    <div class="table-container">
                        <table class="styled-table" id="orderDetails">
                            <thead>
                                <tr>
                                    <th>Item No</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Wood Type</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <?php $id = htmlspecialchars($row['id']) ?>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['size']); ?></td>
                                        <td><?php echo htmlspecialchars($row['qty']); ?></td>
                                        <td><?php echo htmlspecialchars($row['unitPrice']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td>
                                            <button class="button outline" id="view-button" style="margin-right: 10px; padding: 10px; border-radius: 10px;" onclick="window.location.href=`http://localhost/Timberly/public/customer/trackOrderFurniture.php?id=${<?php echo $id ?>}`">view</button>
                                            <button class="button solid" id="delete-button"  style=" padding: 10px; border-radius: 10px;" onclick="deleteItem(<?php echo $id ?>, <?php echo $orderId ?>)">delete</button>                                            
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
                <label for="category">Select Category: </label>
                    <select id="category">
                        <option value="Chair">Chair</option>
                        <option value="Table">Table</option>
                        <option value="Bookshelf">Bookshelf</option>
                        <option value="Wardrobe">Wardrobe</option>
                        <option value="Stool">Stool</option>
                    </select>
            </div>        

                <div class="form-group">
                    <label>Select Design </label>
                    <div id="design-options" class="image-dropdown" style="display:none;">
                        <div class="dropdown">  
                            <div class="dropdown-toggle">                                        
                                <img id="selected-design" src="../images/chair1.jpg" alt="Select Design" width="100">
                            </div>
                            <label><span id="productDescription"></span></label>
                            <div class="dropdown-menu"></div>
                        </div>                                    
                    </div>                                
                </div>

                <div class="form-group">
                    <label>Select Type: </label>
                    <select id="type">
                        <option>Jak</option>
                        <option>Mahogany</option>
                        <option>Teak</option>
                        <option>Sooriyamaara</option>
                        <option>Nedum</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" min="1" max="20" id="qty">
                </div>

                <div class="form-group">
                    <label>Size </label>
                    <select id="size">
                        <option>Small</option>
                        <option>Medium</option>
                        <option>Large</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Additional Information (Mention the dimensions)</label><br>
                     <textarea id="additionalDetails"></textarea>
                </div>
               
            </form>

            <div class="add-button">
                <button type="submit" class="button outline" id="add-item">Add Item</button>
                <button id="close-popup" class="button solid" onclick="closePopup()">Close</button>
            </div>
            
        </div>
    </div>

</body>
</html>

<script>

    let productId;
    let descriptionGlobal;
        document.addEventListener("DOMContentLoaded", function() {
            const furnitureData = <?php echo json_encode($furnitureData); ?>;
            const categorySelect = document.getElementById("category");
            const designOptionsDiv = document.getElementById("design-options");
            const dropdownMenu = document.querySelector(".dropdown-menu");
            const selectedDesign = document.getElementById("selected-design");
            const description = document.getElementById('productDescription');
            
            categorySelect.addEventListener("change", function() {
                const selectedCategory = categorySelect.value;
                dropdownMenu.innerHTML = ""; 
                
                furnitureData.forEach(item => {
                    if (item.category === selectedCategory) {
                        const imgElement = document.createElement("img");
                        imgElement.src = item.image; 
                        imgElement.alt = item.description;                        
                        imgElement.width = 100;
                        imgElement.classList.add("design-option");
                        
                        imgElement.addEventListener("click", function() {
                            selectedDesign.src = item.image;
                            description.textContent = item.description;
                            descriptionGlobal = item.description
                            productId = item.furnitureId;
                            console.log(item.furnitureId+"displaying");
                            

                        });
                        dropdownMenu.appendChild(imgElement);
                    }
                });
                designOptionsDiv.style.display = "block";
            });

            const addButton = document.getElementById("add-item");
            addButton.addEventListener("click", function() {
            if (productId) {
                addItem(productId, <?php echo $orderId ?>);
            } else {
                alert("Please select a design first!");
            }
            });


        });
    </script>

                            

