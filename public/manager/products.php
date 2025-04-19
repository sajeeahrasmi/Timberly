<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';

// Rest of your existing PHP code follows...
?>
<?php include '../../api/Allproducts.php'; ?>
<?php
    include '../../api/session.php' ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Product Page</title>
    <link rel="stylesheet" href="./styles/products.css">
</head>
<body>
    <div id="product-section" class="products-container">
        <h1>Available Products</h1>

        
<div class="tabs">
    <button class="tab active" data-tab="raw-materials" onclick="showTab('raw-materials')">Raw Materials</button>
    <button class="tab" data-tab="furniture" onclick="showTab('furniture')">Furniture</button>
    <button class="tab" data-tab="doors-and-windows" onclick="showTab('doors-and-windows')">Doors and Windows</button>
</div>
<button class="create-product-btn">Create New Product</button>

        
    
<div id="raw-materials" class="tab-content active">
    <div id="product-list">
    <button class ="create-Timber-button" onclick="showTimberModal()">Create Timber</button>
        <div class="supplier">
            <h2 class="supplier-title">Timber </h2>
            <div class="products">
            
                <?php foreach ($timberData as $item): ?>
                    <div class="product-card" data-name="<?php echo htmlspecialchars($item['timberId']); ?>" id ="rtimber">
                   <img src="<?php echo isset($item['image_path']) && !empty($item['image_path']) 
                     ? 'http://localhost/Timberly/api/' . $item['image_path'] 
                     : 'uploads/log.jpeg'; ?>" 
          alt="<?php echo htmlspecialchars($item['type']); ?>" />

                
                    <h3><?php echo htmlspecialchars($item['type']); ?></h3>
                        
                        <p>Diameter: <?php echo htmlspecialchars($item['diameter']); ?> mm</p>
                        <p>Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                        <p>Supplier ID: <?php echo htmlspecialchars($item['supplierId']); ?></p>
                        <p>Quantity: <?php echo htmlspecialchars($item['qty']); ?></p>
                        <div class="card-actions">
                        <button class="edit-btn" >
        <i class="fas fa-edit"></i>
    </button>
    <button class="delete-btn" onclick="deleteTimber(<?php echo $item['timberId']; ?>)" ><i class="fas fa-trash-alt"></i></button>
                </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button class ="create-Lumber-button" onclick="showLumberModal()">Create Lumber</button>
        <div class="supplier">
            <h2 class="supplier-title">Lumber </h2>
            <div class="products">
            
                <?php foreach ($lumberData as $item): ?>
                    <div class="product-card" data-name="<?php echo htmlspecialchars($item['lumberId']); ?>" id ="rlumber">
                    
                    <img src="<?php echo isset($item['image_path']) && !empty($item['image_path']) 
                     ? 'http://localhost/Timberly/api/' . $item['image_path'] 
                     : 'uploads/log.jpeg'; ?>" 
          alt="<?php echo htmlspecialchars($item['type']); ?>" />
                        <h3><?php echo htmlspecialchars($item['type']); ?></h3>
                        <p>Length: <?php echo htmlspecialchars($item['length']); ?> m</p>
                        <p>Width: <?php echo htmlspecialchars($item['width']); ?> mm</p>
                        <p>Thickness: <?php echo htmlspecialchars($item['thickness']); ?> mm</p>
                        <p>Quantity: <?php echo htmlspecialchars($item['qty']); ?></p>
                        <p>Unit Price: Rs.<?php echo htmlspecialchars($item['unitPrice']); ?></p>
                        <div class="card-actions">
                        <button class="edit-btn" >
        <i class="fas fa-edit"></i>
    </button>
    <button class="delete-btn" onclick="deleteLumber(<?php echo $item['lumberId']; ?>)" ><i class="fas fa-trash-alt"></i></button>
                </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


        
<div id="furniture" class="tab-content" style="display: none;">
    <div class="products">
        <?php foreach ($furnitureData as $item): ?>
            <div class="product-card" data-name="<?php echo htmlspecialchars($item['furnitureId']); ?>" id ="ffurniture">
            <img src="<?php echo isset($item['image']) && !empty($item['image']) 
                     ? 'http://localhost/timberly/public/images/' . $item['image'] 
                     : 'uploads/chair.jpg'; ?>" 
          alt="<?php echo htmlspecialchars($item['type']); ?>" />

                <h3><?php echo htmlspecialchars($item['description']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                
                <p>Unit Price: Rs.<?php echo htmlspecialchars($item['unitPrice']); ?></p>
                <p>Category: <?php echo htmlspecialchars($item['category']); ?></p>
                <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                <p>Additional Details: <?php echo htmlspecialchars($item['additionalDetails']); ?></p>
                <div class="card-actions">
                <button class="edit-btn">
        <i class="fas fa-edit"></i>
    </button>
    <button class="delete-btn" onclick="deleteProduct(<?php echo $item['furnitureId']; ?>)" ><i class="fas fa-trash-alt"></i></button>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>


<div id="doors-and-windows" class="tab-content" style="display: none;">
    <div class="products">
        <?php foreach ($doorsAndwindowsData as $item): ?>
            <div class="product-card" data-name="<?php echo htmlspecialchars($item['furnitureId']); ?>" id ="ddoorsandwindows">
            <img src="<?php echo isset($item['image']) && !empty($item['image']) 
                     ? 'http://localhost/timberly/public/images/' . $item['image'] 
                     : 'uploads/decorated-front-door-with-plant_23-2150562176.avif'; ?>" 
          alt="<?php echo htmlspecialchars($item['type']); ?>" />

                <h3><?php echo htmlspecialchars($item['description']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                
                <p>Unit Price: Rs.<?php echo htmlspecialchars($item['unitPrice']); ?></p>
                <p>Category: <?php echo htmlspecialchars($item['category']); ?></p>
                <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
                <p>Additional Details: <?php echo htmlspecialchars($item['additionalDetails']); ?></p>
                <div class="card-actions">
                <button class="edit-btn" >
        <i class="fas fa-edit"></i>
    </button> 
    <button class="delete-btn" onclick="deleteProduct(<?php echo $item['furnitureId']; ?>)" ><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>



        
        <div id="create-order-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Create Product Post</h1>
        <form id="create-order-form" class="create-order-form"  method="post" enctype="multipart/form-data" onsubmit="return validateForm()" >
            
           
            <label for="material_type">Material Type:</label>
            <select id="material_type" name="material_type" >
                <option value="">Select Material Type</option>
                <option value="Jak">Jak</option>
                <option value="Mahogany">Mahogany</option>
                <option value="Teak">Teak</option>
                <option value="Nedum">Nedum</option>
                <option value="Sooriyamaara">Sooriyamaara </option>
            </select>

           

           
            <label for="product_category">Product Category:</label>
            <select id="product_category" name="product_category" required>
                <option value="">Select Category</option>
                <option value="Bookshelf">Bookshelf</option>
                <option value="Stool">Stool</option>
                <option value="Chair">Chair</option>
                <option value="Table">Table</option>
                <option value="Wardrobe">Wardrobe</option>
                <option value="Door">Door</option>
                <option value="Window">Window</option>
                <option value="Transom">Transom</option>
            </select>

            
            <label for="unit_price">Unit Price:</label>
            <input type="number" id="unit_price" name="unit_price"  min="0" required pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price (e.g., 10.99)">

            <label for="product_image">Upload Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*" required>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description"  required pattern="^[A-Za-z\s]+$" title="Description should only contain letters and spaces.">

            <label for="size">Size:</label>
            <select id="size" name="size" required>
                <option value="">Select Size</option>
                <option value="small">small</option>
                <option value="medium">medium</option>
                <option value="large">large</option>
                
            </select>
            <label for="additional_details">Additional Details:</label>
            <input type="text" id="additional_details" name="additional_details" required pattern="^[A-Za-z0-9\s]+$" title="Additional details can include letters, numbers, and spaces.">

            <button type="submit" >Submit </button>
        </form>
    </div>
</div>

<div id="create-timber" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Create Timber</h1>
        <form id="create-timber-form" class="create-timber-class" method="POST" enctype="multipart/form-data">
        <label for="material_type">Material Type:</label>
            <select id="material_type" name="material_type" >
                <option value="">Select Material Type</option>
                <option value="Jak">Jak</option>
                <option value="Mahogany">Mahogany</option>
                <option value="Teak">Teak</option>
                <option value="Nedum">Nedum</option>
                <option value="Sooriyamaara">Sooriyamaara </option>
            </select>


            <label for="diameter">Diameter:</label>
            <input type="number" id="diameter" name="diameter" placeholder="Enter in milimeters" step="0.01" min="100" max="800" required>

            <label for="unit_price">Unit Price:</label>
            <input type="number" id="unit_price" name="unit_price" min="1" required>

            <label for="supplierId">Supplier Id:</label>
            <input type="text" id="supplierId" name="supplierId" required>

            <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" required>
            <button type="submit">Submit Product</button>
        </form>
    </div>
</div>


<div id="create-lumber" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Create Lumber</h1>
        <form id="create-lumber-form" class="create-lumber-class" method="POST" enctype="multipart/form-data">
        <label for="material_type">Material Type:</label>
            <select id="material_type" name="material_type" >
                <option value="">Select Material Type</option>
                <option value="Jak">Jak</option>
                <option value="Mahogany">Mahogany</option>
                <option value="Teak">Teak</option>
                <option value="Nedum">Nedum</option>
                <option value="Sooriyamaara">Sooriyamaara </option>
            </select>


            <label for="length">Length:</label>
            <input type="number" id="length" name="length" placeholder="Enter in meters" step="0.01" min="2.4"  max ="4.8" required>

            <label for="length">Width:</label>
            <input type="number" id="width" name="width"  placeholder="Enter in milimeters" step="0.01" min='50' max="300" required>

            <label for="length">Thickness:</label>
            <input type="number" id="thickness" name="thickness"  placeholder="Enter in milimeters" step="0.01" min='12' max="50" required>

            <label for="length">Quantity:</label>
            <input type="number" id="quantity" name="quantity"  min='1' required>

           
            <label for="unit_price">Unit Price:</label>
            <input type="number" id="unit_price" name="unit_price"  min="1" required>

            <label for="image">Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required>
          

            <button type="submit">Submit Product</button>
        </form>
    </div>
</div>
       
      

    
        
    </div>
    <div id="edit-product-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Edit Product</h1>
        <form id="edit-product-form" class="create-order-form"  action=" " method="post" enctype="multipart/form-data" >
            
            
            <div id="dynamic-fields"></div>

            <button type="submit" class ="save-btn">Save Changes</button>
        </form>
    </div>
</div>


    <script src="./scripts/products.js"></script>
</body>
</html>
