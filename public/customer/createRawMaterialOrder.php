<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Raw Material Order</title>

    <link rel="stylesheet" href="../customer/styles/createRawMaterialOrder.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/createLumberOrder.js" defer></script>

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
            
                <div class="left">  
                    <div class="buttons">
                        <button onclick="window.location.href=`http://localhost/Timberly/public/customer/createDoorOrder.php`" >Door/Window</button>
                        <button onclick="window.location.href=`http://localhost/Timberly/public/customer/createFurnitureOrder.php`">Other furnitures</button>
                        <button style="background-color: #B18068;" onclick="window.location.href=`http://localhost/Timberly/public/customer/createRawMaterialOrder.php`">Raw Materials</button>
                    </div>
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
                                </select>
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
                            <button type="button" onclick="addCard()" class="button outline">Add Item</button>
                        </div>
                        
                    </div>               
                </div>

               
                <div class="right">

                    <div class="right-top">
                        <div class="heading">
                            <h2>Order </h2>
                            <h4 >No.of Items : <span id="noOfItem"></span></h4>
                        </div>
                        <div class="order-list">
                            
                          
                        </div>
                    </div>

                    <div class="order-summary">
                        <h3>Order Summary</h3>
                        <hr>
                        <p>No.of items: <span class="total-amount" id="noOfItems"> </span></p>
                        <p>Total: <span class="total-amount" id="total">Rs. </span></p>
                    </div>

                    <button class="button outline" onclick=placeOrder() >Checkout Order</button>   
                   
                </div>

            </div>
        </div>
            
    </div>

</body>
</html>
