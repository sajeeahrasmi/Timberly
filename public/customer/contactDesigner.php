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
                    <h2>Order #</h2>
                    <div class="product" onclick="openChat('Product 1')">
                        <img src="../images/chair.jpg" alt="Product 1">
                        <p>Product 01: Description</p>
                    </div>
                    <div class="product" onclick="openChat('Product 2')">
                        <img src="../images/chair.jpg" alt="Product 2">
                        <p>Product 02: Description</p>
                    </div>
                    <div class="product" onclick="openChat('Product 3')">
                        <img src="../images/chair.jpg" alt="Product 3">
                        <p>Product 03: Description</p>
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
                        <input type="file" id="image-upload" accept="image/*" style="display:none" onchange="uploadImage(event)">
                        <button onclick="sendMessage()">Send</button>
                    </div>
                </div>
                

            </div>
        </div>
   
    </div>

    
</body>
</html>
