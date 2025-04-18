<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];
echo "<script> console.log({$userId})</script>";
echo "<script> console.log('this is user')</script>";

include '../../config/db_connection.php';

$query1 = "SELECT * FROM user WHERE userId = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $userId);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$name = $row1['name'] ?? 'Driver';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <link rel="stylesheet" href="styles/designer.css">
    <script src="scripts/designer.js"></script>
   
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="../images/final_logo.png" alt="Logo" style="height: 200px; margin: 0%; padding: 0%;"  />
            </div>
            <h1>Welcome  <?php echo $name; ?> !</h1>
            <div class="header-buttons">
                <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/other/designerProfile.php`">Profile</button>
                <button class="button solid" onclick="window.location.href=`http://localhost/Timberly/config/logout.php`">Logout</button>
            </div>
        </div>
        <div class="container1">
            <div class="orders-list">
                <h2>Current Orders</h2>
                <div id="ordersList"></div>
            </div>
    
            <div class="chat-container">
                <div class="chat-header">
                    <span id="customerName">Select an order to start chat</span>
                </div>
                <div class="chat-messages" id="chatMessages"></div>
                <div class="chat-input">
                    <label class="file-upload">
                        <i class="fas fa-image"></i>
                        <input type="file" style="display: none" accept="image/*" onchange="handleFileUpload(event)">
                    </label>
                    <input type="text" placeholder="Type your message..." id="messageInput">
                    <button class="button solid" onclick="sendMessage()">Send</button>
                </div>
            </div>

            <div class="input-image">
                <h2>Input image</h2>
                <h4>Order ID: </h4>
                <h4>Item ID:</h4>

                <label for="imageUpload" class="image-upload-box">
                <img id="previewImage" src="../images/upload.jpg" alt="Click to upload" />
                <input type="file" id="imageUpload" accept="image/*" hidden onchange="previewImage(event)" />
                </label>
                <br><br>
            <button class="button solid">Update</button>
            </div>
        </div>
    </div>

    </body>
</html>