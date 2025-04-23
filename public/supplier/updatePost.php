<?php include '../../api/updatePost.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css">
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
                        <label>Length (m):</label>
                        <input type="number" name="length" value="<?php echo htmlspecialchars($length); ?>" required>

                        <label>Width (mm):</label>
                        <input type="number" name="width" value="<?php echo htmlspecialchars($width); ?>" required>

                        <label>Height (mm):</label>
                        <input type="number" name="height" value="<?php echo htmlspecialchars($height); ?>" required>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label>Diameter (inches):</label>
                        <input type="number" name="diameter" value="<?php echo htmlspecialchars($diameter); ?>" required>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>

                    <label>Price per Unit (LKR):</label>
                    <input type="number" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
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
</html>
