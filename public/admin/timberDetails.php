<?php
    include '../../api/auth.php';
    include '../../api/getTimberDetails.php';
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
            <div style="position: fixed">
                <?php include "./components/sidebar.php" ?>
            </div>
            <div class="main-content" style="margin-left: 300px">
                <?php include "./components/header.php" ?>
                <div class="content">
                    <form id="edit-timber-form">
                        <p style="margin-left:10px">timber</p>
                        <div class="content-header">
                            <div style="display: inline">
                                <h3 style="product-name"><?php echo htmlspecialchars($timber['timberId']); ?></h3>
                            </div>
                            <div class="button-group">
                                <button onclick="confirmDelete()" name="delete" class="delete-button">Delete</button>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Basic Information</h3>
                            
                            <label>Type</label>
                            <select name="type" disabled>
                                <option value="Jak" <?php if ($timber['type'] === 'Jak') echo 'selected'; ?>>Jak</option>
                                <option value="Mahogani" <?php if ($timber['type'] === 'Mahogani') echo 'selected'; ?>>Mahogani</option>
                                <option value="Teak" <?php if ($timber['type'] === 'Teak') echo 'selected'; ?>>Teak</option>
                                <option value="Nedum" <?php if ($timber['type'] === 'Nedum') echo 'selected'; ?>>Nedum</option>
                                <option value="Sooriyamaara" <?php if ($timber['type'] === 'Sooriyamaara') echo 'selected'; ?>>Sooriyamaara</option>
                            </select>

                            <label name="supplierId">SupplierId </label>
                            <input type="text" name="supplierId" value="<?php echo htmlspecialchars($timber['supplierId']); ?>" style="color: grey" readonly>

                            <label>Quantity</label>
                            <input type="number" step="1" min="0" name="qty" value="<?php echo htmlspecialchars($timber['qty']); ?>" style="color: grey" readonly>
                        </div>

                        <div class="form-section">
                            <h3>Dimensions</h3>
                            <label>Diameter (cm)</label>
                            <input type="number" step="0.01" min="0" name="diameter" value="<?php echo htmlspecialchars($timber['diameter']); ?>" style="color: grey" readonly>
                        </div>

                        <div class="form-section">
                            <h3>Pricing</h3>
                            <label>Unit price</label>
                            <input type="number" step="1" min="0" name="unitPrice" value="<?php echo htmlspecialchars($timber['price']); ?>" style="color: grey" readonly>
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
            if (confirm('Are you sure you want to delete this timber? This action cannot be undone.')) {
              document.getElementById('delete-input').value = '1';
              document.getElementById('edit-timber-form').submit();
            }
          }
        </script>
    </body>
</html>
