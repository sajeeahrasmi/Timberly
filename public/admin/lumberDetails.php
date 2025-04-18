<?php
    include '../../api/getLumberDetails.php';
    $message = isset($_GET['message']) ? urldecode($_GET['message']) : '';
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
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div class="content">
                    <form id="edit-lumber-form" method="POST" action="../../api/getLumberDetails.php?lumberId=<?php echo htmlspecialchars($lumberId); ?>" enctype="multipart/form-data">
                        <p style="margin-left:10px">lumber</p>
                        <div class="content-header">
                            <div style="display: inline">
                                <h3 style="product-name"><?php echo htmlspecialchars($lumber['lumberId']); ?></h3>
                            </div>
                            <div class="button-group">
                                <button type="submit" name="save">Save</button>
                                <button onclick="confirmDelete()" name="delete" class="delete-button">Delete</button>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Basic Information</h3>
                            
                            <label>Type</label>
                            <select name="type" required>
                                <option value="Jak" <?php if ($lumber['type'] === 'Jak') echo 'selected'; ?>>Jak</option>
                                <option value="Mahogani" <?php if ($lumber['type'] === 'Mahogani') echo 'selected'; ?>>Mahogani</option>
                                <option value="Teak" <?php if ($lumber['type'] === 'Teak') echo 'selected'; ?>>Teak</option>
                                <option value="Nedum" <?php if ($lumber['type'] === 'Nedum') echo 'selected'; ?>>Nedum</option>
                                <option value="Sooriyamaara" <?php if ($lumber['type'] === 'Sooriyamaara') echo 'selected'; ?>>Sooriyamaara</option>
                            </select>

                            <label>Is post deleted?</label>
                            <select name="is_deleted" required>
                                <option value="1" <?php if ($lumber['is_deleted'] == 1) echo 'selected'; ?>>Yes</option>
                                <option value="0" <?php if ($lumber['is_deleted'] == 0) echo 'selected'; ?>>No</option>
                            </select>

                            <label>Quantity</label>
                            <input type="number" step="1" min="0" name="qty" value="<?php echo htmlspecialchars($lumber['qty']); ?>" required>
                        </div>

                        <div class="form-section">
                            <h3>Dimensions</h3>
                            <label>Length (cm)</label>
                            <input type="number" step="0.01" min="0" name="length" value="<?php echo htmlspecialchars($lumber['length']); ?>" required>

                            <label>Width (cm)</label>
                            <input type="number" step="0.01" min="0" name="width" value="<?php echo htmlspecialchars($lumber['width']); ?>" required>

                            <label>Thickness (mm)</label>
                            <input type="number" step="0.01" min="0" name="thickness" value="<?php echo htmlspecialchars($lumber['thickness']); ?>" required>
                        </div>

                        <div class="form-section">
                            <h3>Pricing</h3>
                            <label>Unit price</label>
                            <input type="number" step="1" min="0" name="unitPrice" value="<?php echo htmlspecialchars($lumber['unitPrice']); ?>" required>
                        </div>
                    </form>
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
            if (confirm('Are you sure you want to delete this lumber? This action cannot be undone.')) {
              document.getElementById('delete-input').value = '1';
              document.getElementById('edit-lumber-form').submit();
            }
          }
        </script>
    </body>
</html>
