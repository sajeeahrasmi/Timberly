<?php include '../../api/Allproducts.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish Product Page</title>
    <link rel="stylesheet" href="./styles/products.css">
</head>
<body>
    <div id="product-section" class="products-container">
        <h1>Available Products</h1>

        <!-- Tabs for Furniture and Raw Materials -->
        <div class="tabs">
            <button class="tab active" onclick="showTab('raw-materials')">Raw Materials</button>
            <button class="tab" onclick="showTab('furniture')">Furniture</button>
        </div>

        <!-- Content for Raw Materials -->
        <div id="raw-materials" class="tab-content active">
            <div id="product-list">
                <?php foreach ($rawMaterialsData as $supplier): ?>
                    <div class="supplier">
                        <h2 class="supplier-title"><?php echo htmlspecialchars($supplier['supplier']); ?></h2>
                        <div class="products">
                            <?php foreach ($supplier['items'] as $item): ?>
                                <div class="product-card" data-name="<?php echo htmlspecialchars($item['name']); ?>">
                                    <img src="./images/log.jpeg" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                                    <p>Unit Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                                    <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Content for Furniture -->
        <div id="furniture" class="tab-content" style="display: none;">
            <div class="products">
                <?php foreach ($furnitureData as $item): ?>
                    <div class="f-card" data-name="<?php echo htmlspecialchars($item['name']); ?>">
                        <img src="./images/chair.jpg" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
                        <p>Material: <?php echo htmlspecialchars($item['material']); ?></p>
                        <p>Unit Price: Rs.<?php echo htmlspecialchars($item['price']); ?></p>
                        <div class="card-actions">
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="create-product-btn">Create New Product</button>
        </div>

      <div id="create-order-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h1>Create Product Post</h1>
        <form id="create-order-form" class="create-order-form" action="createorder.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
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

            <label for="unit_price">Unit Price:</label>
            <input type="number" id="unit_price" name="unit_price" step="0.01" min="0" required>

            <label for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*" required>

            <button type="submit">Submit Order</button>
        </form>
    </div>
</div>

        <div id="confirmation-popup" class="modal">
            <div class="modal-content">
                <h2>Are you sure you want to submit the product?</h2>
                <button id="confirm-submit">Yes, Submit</button>
                <button id="cancel-submit">No, Cancel</button>
            </div>
        </div>

        <!-- Popup for detailed product view -->
        <div id="popup" class="popup-overlay">
            <div class="popup-content">
                <span class="close-popup">&times;</span>
                <h2 id="popup-title"></h2>
                <p id="popup-type"></p>
                <p id="popup-price"></p>
                <p id="popup-quantity"></p>
                <p id="popup-thickness"></p>
                <p id="popup-length"></p>
                <p id="popup-width"></p>
            </div>
        </div>
    </div>

    <script>
        // Function to switch tabs
        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.style.display = tab.id === tabName ? 'block' : 'none';
            });

            const tabButtons = document.querySelectorAll('.tab');
            tabButtons.forEach(button => {
                button.classList.toggle('active', button.getAttribute('data-tab') === tabName);
            });
        }

        // Passing PHP data to JavaScript
        const rawMaterialsData = <?php echo json_encode($rawMaterialsData); ?>;
    </script>
    <script src="./scripts/products.js"></script>
</body>
</html>
