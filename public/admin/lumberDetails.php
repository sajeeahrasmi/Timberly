<?php
// Database connection placeholder
// include('db_connection.php');

// Initialize variables
$message = '';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prod_id = $_POST['prod_id'] ?? '';


    $product = $_POST['product'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $old_price = $_POST['old_price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $visibility = $_POST['visibility'] ?? 'Hidden';

    if (isset($_POST['save'])) {
        // Update product logic
        // $query = "UPDATE products SET name='$name', category='$category', description='$description', price='$price', stock='$stock', visibility='$visibility' WHERE id='$prod_id'";
        // mysqli_query($db_connection, $query);

        $message = 'Product updated successfully!';
    } elseif (isset($_POST['delete'])) {
        // Delete product logic
        // $query = "DELETE FROM products WHERE id='$prod_id'";
        // mysqli_query($db_connection, $query);

        $message = 'Product deleted successfully!';
    }
}

// Handle GET requests for initial data

$prod_id = $_GET['prod_id'] ?? 'Unknown';


$date = $_GET['date'] ?? 'Unknown';
$product = $_GET['product'] ?? 'Unknown';
$category = $_GET['category'] ?? 'Unknown';
$price = $_GET['price'] ?? 0;
$availability = $_GET['availability'] ?? 'Unknown';
$quantity = $_GET['quantity'] ?? 0;
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
                <div class="main-container">
                    <?php include "./components/header.php" ?>
                    <div class="content">
                        <form method="POST">

                            <div class="content-header">
                                <h3><?php echo htmlspecialchars($prod_id); ?></h3>


                                <button type="submit" name="save">Save</button>
                                <button type="submit" name="delete" class="delete-button">Delete</button>
                            </div>
                            <hr class="custom-hr">
                            <p style="color: black; font-size: 13px"><?php echo htmlspecialchars($date); ?></p>
                            <hr class="custom-hr">

                            <div class="form-section">
                                <h3>Basic Information</h3>

                                <input type="hidden" name="prod_id" value="<?php echo htmlspecialchars($prod_id); ?>">

                               

                                <label>Name</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($product); ?>">

                                <label>Category</label>
                                <input type="text" name="category" value="<?php echo htmlspecialchars($category); ?>">

                                <label>Description</label>
                                <textarea name="description" rows="4">Add description link when database connected</textarea>
                            </div>

                            <div class="form-section">
                                <h3>Pricing</h3>
                                <label>Price</label>
                                <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($price); ?>">
                                
                                <label>Old Price</label>
                                <input type="number" step="0.01" name="old_price" value="170.00">
                            </div>

                            <div class="form-section">
                                <h3>Inventory</h3>
                                <label>Stock Quantity</label>
                                <input type="number" name="stock" value="<?php echo htmlspecialchars($quantity); ?>">
                            </div>

                            <div class="form-section">
                                <h3>Visibility</h3>
                                <label>
                                    <input type="radio" name="visibility" value="Published"> Published
                                </label>
                                <label>
                                    <input type="radio" name="visibility" value="Hidden" checked> Hidden
                                </label>
                            </div>
                        </form>
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
    </body>
</html>
