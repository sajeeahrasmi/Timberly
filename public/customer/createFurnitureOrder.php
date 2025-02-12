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
    <script src="../customer/scripts/createDoorOrderScript.js" defer></script>


</head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">
            
                <div class="left">  
                    <div class="buttons">
                        <button onclick="window.location.href=`http://localhost/Timberly/public/customer/createDoorOrder.html`">Door/Window</button>
                        <button style="background-color: #B18068;" onclick="window.location.href=`http://localhost/Timberly/public/customer/createFurnitureOrder.html`">Other furnitures</button>
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

                            <!-- <div class="form-group">
                                <label>Select Design</label>
                                <input type="radio" name="designChoice" id="selectDesign" value="select-design">
                                <br>
                                <div id="design-options" class="image-dropdown" style="display:none;">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle">
                                            <img id="selected-design" src="../images/bookshelf.jpg" alt="Select Design" width="100">
                                        </div>
                                        <div class="dropdown-menu">
                                            <img class="design-option" src="../images/chair.jpg" alt="Design 1" width="100">
                                            <img class="design-option" src="../images/table.jpg" alt="Design 2" width="100">
                        
                                        </div>
                                    </div>
                                </div>                              
                            </div>                    -->

                            <div class="form-group">
                                <label>Select Design</label>
                                <div id="design-options" class="image-dropdown" style="display:none;">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle">
                                            <img id="selected-design" src="../images/default.jpg" alt="Select Design" width="100">
                                        </div>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Select Type: </label>
                                <select>
                                    <option>Jak</option>
                                    <option>Mahogany</option>
                                    <option>Teak</option>
                                    <option>Nedum</option>
                                </select>
                            </div>
                           
                            <!-- <br> -->

                           
                            
                            <!-- <br> -->

                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" min="1" max="100">
                            </div>
                            
                            <!-- <br> -->

                            <div class="form-group">
                                <label>Size </label>
                                <select>
                                    <option>Small</option>
                                    <option>Medium</option>
                                    <option>Large</option>
                                    <!-- <option>Nedum</option> -->
                                </select>
                                <!-- <input type="radio"> -->
                            </div>
                            
                            <!-- <br> -->

                            <div class="form-group">
                                <label>Additional Information</label><br>
                                <textarea></textarea>
                            </div>
                            
                            <!-- <br> -->

                            <!-- <div class="form-group">
                            <button type="submit">Add Item</button>
                            </div> -->

                        </form>
                        <div class="add-button">
                            <button type="submit" class="button outline" >Add Item</button>
                        </div>
                        
                    </div>               
                </div>

               
                <div class="right">
                    <div class="right-top">
                        <h2>Order #</h2>
                        <h3>No.of Items : </h3>
                    </div>

                    <div class="right-middle">
                        <div class="product">
                            <h6>Product 1</h6>
                            <p>Type: </p>
                        </div>
                         
                        <div class="product">
                            <h6>Product 2</h6>
                            <p>Type: </p>
                        </div>
                        <div class="product">
                            <h6>product 3</h6>
                            <p>Type: </p>
                        </div>
                    </div>
                    <div class="right-bottom">
                        <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/customer/orderFurnitureDetails.html`">Checkout Order</button>              
                    </div>      
                   
                </div>

        </div>
        </div>
        
        
        
        
    </div>

</body>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            const furnitureData = <?php echo json_encode($furnitureData); ?>;
            const categorySelect = document.getElementById("category");
            const designOptionsDiv = document.getElementById("design-options");
            const dropdownMenu = document.querySelector(".dropdown-menu");
            const selectedDesign = document.getElementById("selected-design");
            
            categorySelect.addEventListener("change", function() {
                const selectedCategory = categorySelect.value;
                dropdownMenu.innerHTML = ""; // Clear previous images
                
                furnitureData.forEach(item => {
                    if (item.category === selectedCategory) {
                        const imgElement = document.createElement("img");
                        imgElement.src = item.image; // Use stored image path
                        imgElement.alt = item.description;
                        imgElement.width = 100;
                        imgElement.classList.add("design-option");
                        
                        imgElement.addEventListener("click", function() {
                            selectedDesign.src = item.image;
                        });
                        dropdownMenu.appendChild(imgElement);
                    }
                });
                designOptionsDiv.style.display = "block"; // Show image options
            });
        });
    </script>

                            
</html>
