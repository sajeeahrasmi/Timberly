<?php
    include '../../api/getProductDetails.php';
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="stylesheet" href="./styles/productDetails.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
        <script src="./scripts/components/sidebar.js" defer></script>
        <script src="./scripts/components/header.js" defer></script>
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="page-content">
                <div class="main-content">
                    <?php include "./components/header.php" ?>
                    <div class="main-container">
                        <div class="content">
                            <form id="edit-product-form" method="POST" action="../../api/getProductDetails.php?furnitureId=<?php echo htmlspecialchars($furnitureId); ?>" enctype="multipart/form-data">
                                <p>product</p>
                                <div class="content-header">
                                    <div style="display: inline">
                                        <h3 class="product-name"><?php echo htmlspecialchars($product['furnitureId']); ?></h3>
                                    </div>
                                    <div class="button-group">
                                        <button type="submit" name="save">Save</button>
                                        <button type="submit" name="delete" class="delete-button">Delete</button>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h3>Basic Information</h3>
                                    
                                    <label>Name</label>
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($product['description']); ?>">

                                    <label>Category</label>
                                    <select name="category">
                                        <option value="Bookshelf" <?php if ($product['category'] === 'Bookshelf') echo 'selected'; ?>>Bookshelf</option>
                                        <option value="Chair" <?php if ($product['category'] === 'Chair') echo 'selected'; ?>>Chair</option>
                                        <option value="Stool" <?php if ($product['category'] === 'Stool') echo 'selected'; ?>>Stool</option>
                                        <option value="Table" <?php if ($product['category'] === 'Table') echo 'selected'; ?>>Table</option>
                                        <option value="Wardrobe" <?php if ($product['category'] === 'Wardrobe') echo 'selected'; ?>>Wardrobe</option>
                                        <option value="Door" <?php if ($product['category'] === 'Door') echo 'selected'; ?>>Door</option>
                                        <option value="Window" <?php if ($product['category'] === 'Window') echo 'selected'; ?>>Window</option>
                                        <option value="Transom" <?php if ($product['category'] === 'Transom') echo 'selected'; ?>>Transom</option>
                                    </select>

                                    <label>Type</label>
                                    <select name="type">
                                        <option value="Teak" <?php if ($product['type'] === 'Teak') echo 'selected'; ?>>Teak</option>
                                        <option value="Jak" <?php if ($product['type'] === 'Jak') echo 'selected'; ?>>Jak</option>
                                        <option value="Mahogani" <?php if ($product['type'] === 'Mahogani') echo 'selected'; ?>>Mahogani</option>
                                        <option value="Sooriyamaara" <?php if ($product['type'] === 'Sooriyamaara') echo 'selected'; ?>>Sooriyamaara</option>
                                    </select>

                                    <label>Size</label>
                                    <select name="size">
                                        <option value="small" <?php if ($product['size'] === 'small') echo 'selected'; ?>>Small</option>
                                        <option value="medium" <?php if ($product['size'] === 'medium') echo 'selected'; ?>>Medium</option>
                                        <option value="large" <?php if ($product['size'] === 'large') echo 'selected'; ?>>Large</option>
                                    </select>

                                    <label>Additional Details</label>
                                    <textarea name="additionalDetails">
                                        <?php echo htmlspecialchars(trim($product['additionalDetails'])); ?>
                                    </textarea>
                                </div>

                                <div class="form-section">
                                    <h3>Pricing</h3>
                                    <label>Price</label>
                                    <input type="number" step="1" name="unitPrice" value="<?php echo htmlspecialchars($product['unitPrice']); ?>">
                                </div>

                                <div class="form-section">
                                    <h3>Product Photo</h3>
                                    <img id="image-preview" src="<?php echo htmlspecialchars($product['image']) ?>" alt="Product Image" style="max-width: 200px; display: block; margin-top: 10px;">
                                    <input type="file" name="newImage" accept="image/*" onchange="previewImage(event)">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popup for success message -->
            <?php if ($message !== ''): ?>
                <div class="overlay show"></div>
                <div class="popup show">
                    <button class="close-button" onclick="window.history.back()"><i class="fa-solid fa-xmark" style="color: #000000;"></i></button>
                    <img src="../icons/succeeded.png" alt="Success">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>
        </div>
        <script>
          function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
              const output = document.getElementById('image-preview');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
          }

          function confirmDelete() {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
              document.getElementById('delete-input').value = '1';
              document.getElementById('edit-product-form').submit();
            }
          }
        </script>
    </body>
</html>
