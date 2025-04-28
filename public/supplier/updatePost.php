<?php include '../../api/updatePost.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/updatePost.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="updatePost-content">
        <div class="form-content">
            <h1>Update Post Details</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Category: <?php echo htmlspecialchars($category); ?></label>
                </div>

                <div class="form-group">
                    <label for="type">Select Type:</label>
                    <select name="type" required>
                        <option value="Jak" <?php echo $type == 'Jak' ? 'selected' : ''; ?>>Jak</option>
                        <option value="Teak" <?php echo $type == 'Teak' ? 'selected' : ''; ?>>Teak</option>
                        <option value="Mahogani" <?php echo $type == 'Mahogani' ? 'selected' : ''; ?>>Mahogani</option>
                        <option value="Cinamond" <?php echo $type == 'Cinamond' ? 'selected' : ''; ?>>Cinamond</option>
                    </select>
                </div>

                <?php if ($category === 'Lumber'): ?>
                    <div class="form-group">
                        <label>Length (1m-5m):</label>
                        <input type="number" name="length" step="0.01" min="1" max="5" value="<?php echo htmlspecialchars($length); ?>" required>

                        <label>Width (50mm-150mm):</label>
                        <input type="number" name="width" min="50" max="150" value="<?php echo htmlspecialchars($width); ?>" required>

                        <label>Thickness (12mm-50mm):</label>
                        <input type="number" name="thickness" min="12" max="50" value="<?php echo htmlspecialchars($height); ?>" required>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label>Diameter (150mm-450mm):</label>
                        <input type="number" name="diameter" min="150" max="450" value="<?php echo htmlspecialchars($diameter); ?>" required>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" min="1" value="<?php echo htmlspecialchars($quantity); ?>" required>

                    <label>Price per Unit (LKR):</label>
                    <input type="number" name="price" min="1" value="<?php echo htmlspecialchars($price); ?>" required>
                </div>

                <div class="form-group">
                    <label>Additional Info:</label>
                    <textarea name="info" required><?php echo htmlspecialchars($info); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Image:</label>
                    <input type="file" name="image">
                    <?php if (!empty($image)): ?>
                        <img src="../<?php echo htmlspecialchars($image); ?>" alt="Post Image" style="width: 100px;">
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="button outline">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

<script src="scripts/updatePost.js"></script>
</html>
