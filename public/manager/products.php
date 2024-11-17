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
    <button class ="create-Timber-button">Create Timber</button>
        <div class="supplier">
            <h2 class="supplier-title">Timber </h2>
            <div class="products">
            
                <?php foreach ($timberData as $item): ?>
                    <div class="product-card" data-name="<?php echo htmlspecialchars($item['timberId']); ?>" id ="rtimber">
                        <img src="./images/log.jpeg" alt="<?php echo htmlspecialchars($item['type']); ?>">
                        <h3><?php echo htmlspecialchars($item['type']); ?></h3>
                        <p>Diameter: <?php echo htmlspecialchars($item['diameter']); ?> cm</p>
                        <p>Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                        <p>Supplier ID: <?php echo htmlspecialchars($item['supplierId']); ?></p>
                        <div class="card-actions">
                        <button class="edit-btn" >
        <i class="fas fa-edit"></i>
    </button>
                    <button class="delete-btn"><i class="fas fa-trash-alt"></i></button> 
                </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button class ="create-Lumber-button">Create Lumber</button>
        <div class="supplier">
            <h2 class="supplier-title">Lumber </h2>
            <div class="products">
            
                <?php foreach ($lumberData as $item): ?>
                    <div class="product-card" data-name="<?php echo htmlspecialchars($item['lumberId']); ?>" id ="rlumber">
                        <img src="./images/log.jpeg" alt="<?php echo htmlspecialchars($item['type']); ?>">
                        <h3><?php echo htmlspecialchars($item['type']); ?></h3>
                        <p>Length: <?php echo htmlspecialchars($item['length']); ?> cm</p>
                        <p>Width: <?php echo htmlspecialchars($item['width']); ?> cm</p>
                        <p>Thickness: <?php echo htmlspecialchars($item['thickness']); ?> cm</p>
                        <p>Quantity: <?php echo htmlspecialchars($item['qty']); ?></p>
                        <p>Unit Price: Rs.<?php echo htmlspecialchars($item['unitPrice']); ?></p>
                        <div class="card-actions">
                        <button class="edit-btn" >
        <i class="fas fa-edit"></i>
    </button>
                    <button class="delete-btn"><i class="fas fa-trash-alt"></i></button> 
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
            <div class="product-card" data-name="<?php echo htmlspecialchars($item['productId']); ?>" id ="ffurniture">
                <img src="./images/chair.jpg" alt="<?php echo htmlspecialchars($item['productId']); ?>">
                <h3><?php echo htmlspecialchars($item['description']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                
                <p>Unit Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                <p>Review: <?php echo htmlspecialchars($item['review']); ?></p>
                <div class="card-actions">
                <button class="edit-btn">
        <i class="fas fa-edit"></i>
    </button>
    <button class="delete-btn" onclick="deleteProduct(<?php echo $item['productId']; ?>)" ><i class="fas fa-trash-alt"></i></button>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>


<div id="doors-and-windows" class="tab-content" style="display: none;">
    <div class="products">
        <?php foreach ($doorsAndwindowsData as $item): ?>
            <div class="product-card" data-name="<?php echo htmlspecialchars($item['productId']); ?>" id ="ddoorsandwindows">
                <img src="./images/decorated-front-door-with-plant_23-2150562176.avif" alt="<?php echo htmlspecialchars($item['productId']); ?>">
                <h3><?php echo htmlspecialchars($item['description']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                
                <p>Unit Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                <p>Review: <?php echo htmlspecialchars($item['review']); ?></p>
                <div class="card-actions">
                <button class="edit-btn" >
        <i class="fas fa-edit"></i>
    </button> 
    <button class="delete-btn" onclick="deleteProduct(<?php echo $item['productId']; ?>)" ><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>



        
        <div id="create-order-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Create Product Post</h1>
        <form id="create-order-form" class="create-order-form"  method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            
           
            <label for="material_type">Material Type:</label>
            <select id="material_type" name="material_type" >
                <option value="">Select Material Type</option>
                <option value="Sooriyam">Jak</option>
                <option value="Mahogany">Mahogany</option>
                <option value="Teak">Teak</option>
                <option value="Nedum">Nedum</option>
                <option value="Sooriyam">Sooriyam </option>
            </select>

           

           
            <label for="product_category">Product Category:</label>
            <select id="product_category" name="product_category" required>
                <option value="">Select Category</option>
                <option value="furniture">Furniture</option>
                <option value="doorsandwindows">Doors and Windows</option>
            </select>

            
            <label for="unit_price">Unit Price:</label>
            <input type="number" id="unit_price" name="unit_price" step="0.01" min="0" required>

            
            <label for="description">Description:</label>
            <input type="text" id="description" name="description"  required>

            <button type="submit1" >Submit </button>
        </form>
    </div>
</div>


       
      

    
        
    </div>
    <div id="edit-product-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Edit Product</h1>
        <form id="edit-product-form" class="create-order-form"  action=" " method="post" enctype="multipart/form-data">
            
            
            <div id="dynamic-fields"></div>

            <button type="submit" class ="save-btn">Save Changes</button>
        </form>
    </div>
</div>


    <script src="./scripts/products.js"></script>
</body>
</html>
