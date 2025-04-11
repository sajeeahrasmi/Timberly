<?php
include '../../config/db_connection.php'; 

$query = "SELECT * FROM furnitures";
$result = mysqli_query($conn, $query);
$furnitureData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $furnitureData[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Furniture Order</title>

    <link rel="stylesheet" href="../customer/styles/createDoorOrder.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/createFurnitureOrder.js" defer></script>


</head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">
            
                <div class="left">  
                    <div class="buttons">
                        <button onclick="window.location.href=`http://localhost/Timberly/public/customer/createDoorOrder.php`">Door/Window</button>
                        <button style="background-color: #B18068;" onclick="window.location.href=`http://localhost/Timberly/public/customer/createFurnitureOrder.php`">Other furnitures</button>
                        <button onclick="window.location.href=`http://localhost/Timberly/public/customer/createRawMaterialOrder.html`">Raw Materials</button>
                    </div>
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
                            <button type="button" class="button outline" id="add-item">Add Item</button>
                        </div>
                        
                    </div>               
                </div>

               
                <div class="right">
                    <div class="right-top">
                        <h2>Order </h2>
                        <h4 >No.of Items : <span id="noOfItem"></span></h4>
                    </div>

                    <div class="right-middle">
                        <div class="order-list"></div>
                        
                    </div>
                    <div class="right-bottom">
                        <button class="button outline" onclick=placeOrder()>Checkout Order</button>              
                    </div>      
                   
                </div>

        </div>
        </div>
     
    </div>

</body>

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
                            console.log(item.furnitureId);
                            

                        });
                        dropdownMenu.appendChild(imgElement);
                    }
                });
                designOptionsDiv.style.display = "block";
            });

            const addButton = document.getElementById("add-item");
            addButton.addEventListener("click", function() {
            if (productId) {
                addCard(productId, descriptionGlobal);
            } else {
                alert("Please select a design first!");
            }
        });


        });
    </script>

                            

</html>
