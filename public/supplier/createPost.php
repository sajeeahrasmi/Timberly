<?php include '../../api/createPost.php'; // Adjust path if needed
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="/Supplier/styles/createPost.css">
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
    <div class="createPost-content">
            <div class="form-content">
                <h1>Create Post Details</h1>
                <form action="createPost.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="category">Select Category:</label>
                        <select id="category" name="category" required>
                            <option value="Timber">Timber</option>
                            <option value="Lumber">Lumber</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Select Type:</label>
                        <select id="type" name="type" required>
                            <option value="Jak">Jak</option>
                            <option value="Teak">Teak</option>
                            <option value="Mahogani">Mahogani</option>
                            <option value="Cinamond">Cinamond</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="length">Length(m):</label>
                        <input type="number" name="length" placeholder="Enter the length" required min="0">

                        <label for="width">Width(mm):</label>
                        <input type="number" name="width" placeholder="Enter the width" required min="0">

                        <label for="height">Height(mm):</label>
                        <input type="number" name="height" placeholder="Enter the height" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" placeholder="Enter the quantity" required min="1">

                        <label for="price">Price per Unit:</label>
                        <input type="number" name="price" placeholder="Enter the price per unit" required min="1">
                    </div>

                    <div class="form-group">
                        <label for="info">Additional Information:</label><br>
                        <textarea name="info" placeholder="Enter additional information" ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="button outline">Add Post</button>
                    </div>
                </form>
            </div>
    </div>
</div>

</body>
</html>
