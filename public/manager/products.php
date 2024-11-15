<?php include '../../api/Allproducts.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Stylish Product Page</title>
    <link rel="stylesheet" href="./styles/products.css">
</head>
<body>
    <div id="product-section" class="products-container">
        <h1>Available Products</h1>

        <!-- Tabs for Furniture, Raw Materials, and Doors and Windows -->
        <div class="tabs">
            <button class="tab active" onclick="showTab('raw-materials')">Raw Materials</button>
            <button class="tab" onclick="showTab('furniture')">Furniture</button>
            <button class="tab" onclick="showTab('doors-and-windows')">Doors and Windows</button>
        </div>

        <!-- Content for Raw Materials -->
    <!-- Raw Materials Content -->
<div id="raw-materials" class="tab-content active">
    <div id="product-list">
        <!-- Timber Data -->
        <div class="supplier">
            <h2 class="supplier-title">Timber </h2>
            <div class="products">
                <?php foreach ($timberData as $item): ?>
                    <div class="product-card" data-name="<?php echo htmlspecialchars($item['type']); ?>">
                        <img src="./images/log.jpeg" alt="<?php echo htmlspecialchars($item['type']); ?>">
                        <h3><?php echo htmlspecialchars($item['type']); ?></h3>
                        <p>Diameter: <?php echo htmlspecialchars($item['diameter']); ?> cm</p>
                        <p>Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                        <p>Supplier ID: <?php echo htmlspecialchars($item['supplierId']); ?></p>
                        <div class="card-actions">
                    <button class="edit-btn"><i class="fas fa-edit"></i></button> <!-- Icon for Edit -->
                    <button class="delete-btn"><i class="fas fa-trash-alt"></i></button> <!-- Icon for Delete -->
                </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Lumber Data -->
        <div class="supplier">
            <h2 class="supplier-title">Lumber </h2>
            <div class="products">
                <?php foreach ($lumberData as $item): ?>
                    <div class="product-card" data-name="<?php echo htmlspecialchars($item['type']); ?>">
                        <img src="./images/log.jpeg" alt="<?php echo htmlspecialchars($item['type']); ?>">
                        <h3><?php echo htmlspecialchars($item['type']); ?></h3>
                        <p>Length: <?php echo htmlspecialchars($item['length']); ?> cm</p>
                        <p>Width: <?php echo htmlspecialchars($item['width']); ?> cm</p>
                        <p>Thickness: <?php echo htmlspecialchars($item['thickness']); ?> cm</p>
                        <p>Quantity: <?php echo htmlspecialchars($item['qty']); ?></p>
                        <p>Unit Price: Rs.<?php echo htmlspecialchars($item['unitPrice']); ?></p>
                        <div class="card-actions">
                    <button class="edit-btn"><i class="fas fa-edit"></i></button> <!-- Icon for Edit -->
                    <button class="delete-btn"><i class="fas fa-trash-alt"></i></button> <!-- Icon for Delete -->
                </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


        <!-- Content for Furniture -->
       <!-- For Furniture Content -->
<div id="furniture" class="tab-content" style="display: none;">
    <div class="products">
        <?php foreach ($furnitureData as $item): ?>
            <div class="f-card" data-name="<?php echo htmlspecialchars($item['productId']); ?>">
                <img src="./images/chair.jpg" alt="<?php echo htmlspecialchars($item['productId']); ?>">
                <h3><?php echo htmlspecialchars($item['description']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                
                <p>Unit Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                <p>Review: <?php echo htmlspecialchars($item['review']); ?></p>
                <div class="card-actions">
                    <button class="edit-btn"><i class="fas fa-edit"></i></button> <!-- Icon for Edit -->
                    <button class="delete-btn"><i class="fas fa-trash-alt"></i></button> <!-- Icon for Delete -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="create-product-btn">Create New Product</button>
</div>

<!-- For Doors and Windows Content -->
<div id="doors-and-windows" class="tab-content" style="display: none;">
    <div class="products">
        <?php foreach ($doorsAndwindowsData as $item): ?>
            <div class="product-card" data-name="<?php echo htmlspecialchars($item['productId']); ?>">
                <img src="./images/decorated-front-door-with-plant_23-2150562176.avif" alt="<?php echo htmlspecialchars($item['productId']); ?>">
                <h3><?php echo htmlspecialchars($item['description']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                
                <p>Unit Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                <p>Review: <?php echo htmlspecialchars($item['review']); ?></p>
                <div class="card-actions">
                    <button class="edit-btn"><i class="fas fa-edit"></i></button> <!-- Icon for Edit -->
                    <button class="delete-btn"><i class="fas fa-trash-alt"></i></button> <!-- Icon for Delete -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


        <!-- Modal for Creating New Products -->
        <div id="create-order-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Create Product Post</h1>
        <form id="create-order-form" class="create-order-form" action="createorder.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            
            <!-- Material Type Selection -->
            <label for="material_type">Material Type:</label>
            <select id="material_type" name="material_type" required onchange="checkCustomMaterial(this)">
                <option value="">Select Material Type</option>
                <option value="Mahogany">Mahogany</option>
                <option value="Teak">Teak</option>
                <option value="Oak">Oak</option>
                <option value="other">Other (Please specify)</option>
            </select>

            <label for="custom_material_type" id="custom_material_label" style="display:none;">Custom Material:</label>
            <input type="text" id="custom_material_type" name="custom_material_type" style="display:none;">

            <!-- Product Category Selection (Furniture or Door/Window) -->
            <label for="product_category">Product Category:</label>
            <select id="product_category" name="product_category" required>
                <option value="">Select Category</option>
                <option value="furniture">Furniture</option>
                <option value="door-window">Doors and Windows</option>
            </select>

            <!-- Unit Price -->
            <label for="unit_price">Unit Price:</label>
            <input type="number" id="unit_price" name="unit_price" step="0.01" min="0" required>

            <!-- Product Image -->
            <label for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*" required>

            <button type="submit">Submit Order</button>
        </form>
    </div>
</div>


        <!-- Confirmation Popup -->
        <div id="confirmation-popup" class="modal">
            <div class="modal-content">
                <h2>Are you sure you want to submit the product?</h2>
                <button id="confirm-submit">Yes, Submit</button>
                <button id="cancel-submit">No, Cancel</button>
            </div>
        </div>

        <!-- Popup for Detailed Product View -->
        
    </div>

    <script src="./scripts/products.js"></script>
</body>
</html>
