<?php

$orderId = $_GET['orderId'];
$itemId = $_GET['itemId'];


include '../../config/db_connection.php';
include '../../config/customer/getcdetails.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details & Chat</title>

    <link rel="stylesheet" href="../customer/styles/contactDesigner.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/contactDesigner.js"></script>
    <script src="../customer/scripts/header.js"></script>
    <script src="../customer/scripts/sidebar.js"></script>

</head>

<body>
    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">                  
                <div class="product-list">
                    <h2>Order # <?php echo $orderId; ?></h2>
                    <h3>Item # <?php echo $itemId; ?></h3>
                    
                   

                   
                    
                    <?php
                    $query = "SELECT * FROM ordercustomizedfurniture WHERE orderId = ? AND itemId = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ii", $orderId, $itemId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $type = $row['type'] ?? 'N/A';
                    $details = $row['details'] ?? 'N/A';
                    $category = $row['category'] ?? 'N/A';
                    $image = $row['image'] ?? '../images/furniture.jpg';
                    ?>
                    <div class="product-list-item">
                        <div class="product-image">
                            
                            <img src="<?php echo $image; ?>" alt="Product Image" style="width: 100px; height: 100px;">
                            
                            <div class="product-details">
                                <h4>Product Type: <?php echo $type; ?></h4>
                                <p>Details: <?php echo $details; ?></p>
                                <p>Category: <?php echo $category; ?></p>



</div>
</div>


<button class="chat-button" style = "background-color: #895D47; /* Green */
    border: none;
    border-radius: 4px;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
   
    margin: -4px -3px;
    cursor: pointer;
}" onclick="openChat(<?php echo $itemId; ?>,<?php echo $orderId; ?>)">Chat with Designer</button>
</div>



                    
                </div>
                
                <div class="chat-box">
                    <h2 id="chat-header">Select a Product to Chat</h2>
                    <div id="chat-content">
                        <p>Select a product on the left to start a conversation.</p>
                    </div>
                    <div class="chat-input">
                        <input type="text" id="chat-message" placeholder="Type a message...">
                        
                        <label for="image-upload" class="upload-button"><span><i class="fa-solid fa-camera"></i></span></label>
                        <input type="file" id="image-upload" accept="image/*" data-item-id="<?php echo $itemId; ?>" 
                        data-order-id="<?php echo $orderId; ?>" style="display:none" onchange="uploadImage(event)">
                        <button onclick="sendMessage(<?php echo $itemId; ?>,<?php echo $orderId; ?>)">Send</button>
                    </div>
                </div>
                

            </div>
        </div>
   
    </div>

    
</body>
</html>
