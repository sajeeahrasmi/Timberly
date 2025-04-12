<?php
include '../../api/updatePost.php'; // Adjust path if needed
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="/Supplier/styles/updatePost.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<!-- Wrap Sidebar and Body in .body-container -->
<div class="body-container">
    <!-- Sidebar -->
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <!-- Main Content Area -->
    <div class="updatePost-content">
                <div class="form-content">
                    <h1>Update Post Details</h1>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="category">Select Category: </label>
                            <select id="category" name="category" required>
                                <option value="Timber" <?php echo $category == 'Timber' ? 'selected' : ''; ?>>Timber</option>
                                <option value="Lumber" <?php echo $category == 'Lumber' ? 'selected' : ''; ?>>Lumber</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type">Select Type: </label>
                            <select name="type" required>
                                <option value="Jak" <?php echo $type == 'Jak' ? 'selected' : ''; ?>>Jak</option>
                                <option value="Teak" <?php echo $type == 'Teak' ? 'selected' : ''; ?>>Teak</option>
                                <option value="Mahogani" <?php echo $type == 'Mahogani' ? 'selected' : ''; ?>>Mahogani</option>
                                <option value="Cinamond" <?php echo $type == 'Cinamond' ? 'selected' : ''; ?>>Cinamond</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="length">Length(m):</label>
                            <input type="number" name="length" value="<?php echo htmlspecialchars($length); ?>" required min="0">

                            <label for="width">Width(mm):</label>
                            <input type="number" name="width" value="<?php echo htmlspecialchars($width); ?>" required min="0">

                            <label for="height">Height(mm):</label>
                            <input type="number" name="height" value="<?php echo htmlspecialchars($height); ?>" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required min="1">

                            <label for="price">Price per Unit(LKR):</label>
                            <input type="number" name="price" value="<?php echo htmlspecialchars($price); ?>" required min="1">
                        </div>

                        <div class="form-group">
                            <label for="info">Additional Information:</label><br>
                            <textarea name="info" required><?php echo htmlspecialchars($info); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Upload Image:</label>
                            <input type="file" name="image">
                            <?php if (!empty($image)): ?>
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="Post Image" style="width: 100px; height: auto;">
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="button outline">Update Post</button>
                        </div>
                    </form>
                </div>
</div>

</body>
</html>
