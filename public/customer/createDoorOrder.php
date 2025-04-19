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
    <title>Create Door/Window Order</title>

    <link rel="stylesheet" href="http://localhost/Timberly/public/customer/styles/createDoorOrder.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/createDoorOrderScript.js" defer></script>

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
                        <button style="background-color: #B18068;" onclick="window.location.href=`http://localhost/Timberly/public/customer/createDoorOrder.php`">Door/Window</button>
                        <button onclick="window.location.href=`http://localhost/Timberly/public/customer/createFurnitureOrder.php`">Other furnitures</button>
                        <button onclick="window.location.href=`http://localhost/Timberly/public/customer/createRawMaterialOrder.php`">Raw Materials</button>
                    </div>
                    <div class="form-content">
                        <h4>Item Details</h4>
                        <form>
                            <div class="form-group">
                                <label for="category">Select Category: </label>
                                <select id="category">
                                    <option value="Door">Door</option>
                                    <option value="Window">Window</option>
                                    <option value="Transom">Transom</option>
                                </select>
                            </div>
                        

                            <div class="form-group">
                                <label>Select Design</label>
                                <input type="radio" name="designChoice" id="selectDesign" value="select-design">
                                <label>Input Design</label>
                                <input type="radio" name="designChoice" id="inputDesign" value="input-design">
                                <br>

                                <div id="design-options" class="image-dropdown" style="display:none;">
                                    <div class="dropdown">  
                                        <div class="dropdown-toggle">                                        
                                            <img id="selected-design" src="../images/door1.jpg" alt="Select Design" width="100">
                                        </div>
                                        <label><span id="productDescription"></span></label>
                                        <div class="dropdown-menu"></div>
                                    </div>                                    
                                </div> 

                               
                                <div id="upload-design" style="display:none;">
                                    <label for="customDesign">Upload Your Design:</label>
                                    <input type="file" id="customDesign" name="customDesign" accept="image/*">
                                    <img id="imagePreview" style="display:none; width: 100px; margin-top: 10px;" />
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
                                <h5>Size</h5>
                                <label>Length (m) </label>
                                <input type="number" id="length" min = 1 max = 5>
                                <label>Width (mm) </label>
                                <input type="number" id="width" min = 1 max = 1500>
                                <label>Thickness (mm) </label>
                                <input type="number" id="thickness" min = 1 max = 50>
                            </div>


                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" min="1" max="20" id="qty">
                            </div>


                            <div class="form-group">
                                <label>Additional Information</label><br>
                                <textarea id="additionalDetails"></textarea>
                            </div>


                        </form>
                        <div class="add-button">
                            <button type="submit" class="button outline" id="add-item">Add Item</button>
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
                        <button class="button outline" onclick=placeDoorOrder()>Checkout Order</button>              
                    </div>      
                   
                </div>

        </div>
        </div>
        
    
    </div>

</body>



<script>
    let productId;
    let descriptionGlobal;

    document.addEventListener("DOMContentLoaded", function () {
        const selectRadio = document.getElementById("selectDesign");
        const inputRadio = document.getElementById("inputDesign");
        const uploadDesignDiv = document.getElementById("upload-design");
        const designOptionsDiv = document.getElementById("design-options");
        const selectedDesign = document.getElementById("selected-design");
        const description = document.getElementById('productDescription');

        const furnitureData = <?php echo json_encode($furnitureData); ?>;
        const categorySelect = document.getElementById("category");
        const dropdownMenu = document.querySelector(".dropdown-menu");

       
        categorySelect.addEventListener("change", function () {
            const selectedCategory = categorySelect.value;
            dropdownMenu.innerHTML = "";

            furnitureData.forEach(item => {
                if (item.category === selectedCategory) {
                    const imgElement = document.createElement("img");
                    imgElement.src = item.image;
                    imgElement.alt = item.description;
                    imgElement.width = 100;
                    imgElement.classList.add("design-option");

                    imgElement.addEventListener("click", function () {
                        selectedDesign.src = item.image;
                        description.textContent = item.description;
                        descriptionGlobal = item.description;
                        productId = item.furnitureId;
                    });

                    dropdownMenu.appendChild(imgElement);
                }
            });

            if (selectRadio.checked) {
                designOptionsDiv.style.display = "block";
            }
        });

       
        selectRadio.addEventListener("change", function () {
            if (selectRadio.checked) {
                designOptionsDiv.style.display = "block";
                uploadDesignDiv.style.display = "none";
            }
        });

        inputRadio.addEventListener("change", function () {
            if (inputRadio.checked) {
                designOptionsDiv.style.display = "none";
                uploadDesignDiv.style.display = "block";
                selectedDesign.src = "../images/door1.jpg";
                description.textContent = "";
                productId = null;
                descriptionGlobal = "";
            }
        });



    });




</script>

</html>
