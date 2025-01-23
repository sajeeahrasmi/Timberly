<?php
$material = ''; // get the selected material from the form submission
$message = '';
$popupType = ''; // To determine success or failure popup
$category = '';
$length = '';
$width = '';
$thickness = '';
$price = '';
$type = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $material = $_GET['material'] ?? '';
    $message = 'Material selected!';
    $category = $_GET['category'] ?? '';
    $length = $_GET['length'] ?? '';
    $width = $_GET['width'] ?? '';
    $thickness = $_GET['thickness'] ?? '';
    $price = $_GET['price'] ?? '';
    $type = $_GET['type'] ?? '';
    $description = $_GET['description'] ?? '';

    if ($material === 'product') {
        $categories = array('Chair', 'Table', 'Pantry-cupboards'); // categories for product
        $types = array('Mahogani', 'Kaluwara', 'Handun', 'Thekka'); // types for product
    } elseif ($material === 'raw_materials') {
        $categories = array('Timber', 'Lumber'); // categories for raw materials
        $types = array('Mahogani', 'Kaluwara', 'Handun', 'Thekka'); // types for raw materials
    } else {
        $categories = array(); // default categories
        $types = array(); // default types
    }
    if (isset($_GET['create_post'])) {
        // Validate all fields are filled
        if (!empty($material) && !empty($category) && !empty($length) && !empty($width) && !empty($thickness) && !empty($price) && !empty($type) && !empty($description)) {
            $popupType = 'success'; // Show success popup
            $message = 'Post created successfully!';
            // Here you can add the code to save the post in the database
        } else {
            $popupType = 'failure'; // Show failure popup
            $message = 'Failed to create the post. Please fill all fields.';
        }
    }
} else {
    $categories = array(); // default categories
    $types = array(); // default types
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly Ltd</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/createPost.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>

            <div class="page-content">
                <div class="main-content">
                    <?php include "./components/header.php" ?>
                    <form method="GET">
                        <h3>Create Post</h3>
                        <div class="form-body">
                            <div class="image-upload-box">
                                <input type="file" name="new_image" id="image-upload-input">
                                <label for="image-upload-input">Upload</label>
                            </div>
                            <div class="form-filling">
                                <div style="display: grid; grid-template-columns: repeat(2,1fr);">
                                    <div class="main-category-selection" style="margin-bottom: 10px">
                                        <label style="width: 150px; font-weight: bold">
                                            <input type="radio" name="material" value="product" checked <?php if ($material == 'product') echo 'checked'; ?>> Product
                                        </label>
                                        <label style="width: 150px; font-weight: bold">
                                            <input type="radio" name="material" value="raw_materials" <?php if ($material == 'raw_materials') echo 'checked'; ?>> Raw materials
                                        </label>
                                    </div>
                                    <button class="Selector-submission" type="submit">Select type</button>
                                </div>
                                <?php if (!empty($material)): ?>
                                <div>
                                    <label for="category">Category</label>
                                    <select class="selector" id="category" name="category">
                                        <option value="">--Select--</option>
                                        <?php foreach ($categories as $cat) { ?>
                                            <option value="<?php echo $cat; ?>" <?php if ($category == $cat) echo 'selected'; ?>><?php echo $cat; ?></option>
                                        <?php } ?>
                                    </select>

                                    <div class="input-group">
                                        <label for="length">Length (cm)
                                            <input type="number" id="length" name="length" value="<?php echo $length; ?>" step="0.1" min="0">
                                        </label>

                                        <label for="width">Width (cm)
                                            <input type="number" id="width" name="width" value="<?php echo $width; ?>" step="0.1" min="0">
                                        </label>

                                        <label for="thickness">Thickness/height (cm)
                                            <input type="number" id="thickness" name="thickness" value="<?php echo $thickness; ?>" step="0.1" min="0">
                                        </label>

                                        <label for="price">Price (Rs)
                                            <input type="number" id="price" name="price" value="<?php echo $price; ?>" step="0.01" min="0">
                                        </label>
                                    </div>

                                    <label for="type">Type</label>
                                    <select class="selector" id="type" name="type">
                                        <option value="">--Select--</option>
                                        <?php foreach ($types as $t) { ?>
                                            <option value="<?php echo $t; ?>" <?php if ($type == $t) echo 'selected'; ?>><?php echo $t; ?></option>
                                        <?php } ?>
                                    </select>

                                    <label for="description">Description</label>
                                    <textarea id="description" name="description"><?php echo $description; ?></textarea>

                                    <div class="form-footer">
                                        <a href="index.php">Cancel</a>
                                        <button name="create_post" type="submit">Create the post</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if ($popupType === 'success' || $popupType === 'failure'): ?>
            <div class="overlay show"></div>
            <div class="popup show">
                <button class="close-button" onclick="window.history.back()"><i class="fa-solid fa-xmark" style="color: #000000;"></i></button>
                <img src="<?php echo $popupType === 'success' ? './icons/succeeded.png' : './icons/failure.png'; ?>" alt="<?php echo $popupType; ?> Icon">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
    </body>
</html>

<script src="./scripts/components/sidebar.js" defer></script>
