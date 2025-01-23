 <?php
include 'db.php'; // Ensure your database connection is working

// Check if the `id` parameter is passed in the URL
if (isset($_GET['id'])) {
    // Get the `id` parameter
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Fetch the post details from the database
    $sql = "SELECT * FROM crudpost WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Assign values to variables
        $category = $row['category'];
        $type = $row['type'];
        $length = $row['length'];
        $width = $row['width'];
        $height = $row['height'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $info = $row['info'];
        $image = $row['image'];
    } else {
        // If no post found
        echo "Post not found.";
        exit; // Stop further execution
    }
} else {
    // If 'id' is not passed
    echo "Invalid request. No post ID provided.";
    exit;
}

// Handle form submission for updating the post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $length = mysqli_real_escape_string($con, $_POST['length']);
    $width = mysqli_real_escape_string($con, $_POST['width']);
    $height = mysqli_real_escape_string($con, $_POST['height']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $info = mysqli_real_escape_string($con, $_POST['info']);

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Update the record in the database
    $sql = "UPDATE crudpost 
            SET category = '$category', type = '$type', length = '$length', 
                width = '$width', height = '$height', quantity = '$quantity', price = '$price',
                info = '$info', image = '$image' 
            WHERE id = $id";

    if (mysqli_query($con, $sql)) {
        echo "Post updated successfully!";
        header('Location: display.php'); // Redirect back to the display page
        exit;
    } else {
        echo "Error updating post: " . mysqli_error($con);
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link rel="stylesheet" href="../styles/globals.css">
    <link rel="stylesheet" href="../styles/layout.css">
    <link rel="stylesheet" href="../Update Post/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<div class="popup" id="notification-popup">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Notifications</h3>
                <button class="popup-close-button" style="color:var(--color-primary)"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
                <button class="popup-trigger" data-popup-id="not-1">
                    <div class="pop1">
                    <div class="notification-message">Order Payment paid successfully!</div>
                    <div class="notification-timestamp">2024-11-25 02:15 PM</div> 
                    </div>
                 
                </button>

                <button class="popup-trigger" data-popup-id="not-2">
                    <div class="pop2">
                    <div class="notification-message">Your post has been approved!</div>
                    <div class="notification-timestamp">2024-11-27 10:30 AM</div>
                    </div>
                </button>

                <button class="popup-trigger" data-popup-id="not-3">
                    <div class="pop3">
                    <div class="notification-message">Timber stock is running low!</div>
                    <div class="notification-timestamp">2024-11-27 10:30 AM</div>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <div class="popup" id="not-1">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Order Payment paid successfully!</h3>
                <button class="popup-close-button" style="color:var(--color-primary)"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
            The message "Order Payment Paid Successfully!" serves as a confirmation to both the supplier and the woodworking company 
            that the payment for an order has been processed without any issues. This notification is essential in maintaining 
            transparency and trust between the supplier and the buyer, ensuring the transaction is complete and ready for the next 
            steps, such as delivery or invoicing.
            </div>
        </div>
    </div>
    <div class="popup" id="not-2">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Your post has been approved!</h3>
                <button class="popup-close-button"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
            This notification confirms that the post you submitted has successfully passed the review process and is now live or 
            visible to others. It reassures you that your content meets the necessary guidelines and encourages further engagement.
            </div>
        </div>
    </div>
    <div class="popup" id="not-3">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Timber stock is running low!</h3>
                <button class="popup-close-button" style="color:var(--color-primary)"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
            This notification alerts you that the stock of a specific type of timber is nearing depletion. It serves as a reminder 
            to restock promptly to avoid delays in fulfilling orders or disruptions in production.
            </div>
        </div>
    </div> 
<header>
    <div class="header-content">
        <div class="header-logo">Timberly</div>
        <nav class="header-nav">
            <button data-popup-id="notification-popup" class="header-link popup-trigger"><i
                    class="fa-solid fa-bell"></i></button>
            <a href="../Update Profile/updateprofile.html" class="header-link"><i class="fa-solid fa-user"></i></a>
        </nav>
    </div>
</header>


    <div class="body-content-wrapper">
        <div class="sidebar">
            <div class="sidebar-content">
                <a href="../Dashboard/dashboard.html" class="sidebar-link"><i class="fa-solid fa-house icon"></i>Dashboard</a>
                <a href="../Backend/create.php" class="sidebar-link"><i class="fa-solid fa-plus"></i>Create Post</a>
                <a href="../Backend/display.php" class="sidebar-link active"><i class="fa-solid fa-box"></i>Supplier Posts</a>
                <a href="../Posts/approved.html" class="sidebar-link"><i class="fa-solid fa-bag-shopping"></i>Supplier Orders</a>
                <a href="../Update Profile/updateprofile.html" class="sidebar-link"><i class="fas fa-user"></i>User Profile</a>
                <a href="http://localhost/Timberly/config/logout.php" class="sidebar-link"><i class="fa-solid fa-right-from-bracket icon"></i>Log Out</a>
            </div>
        </div>

        <div class="body-content-container">
            <div class="body-content">
                <div class="left">
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
        </div>
        </div>
    </div>

    <script src="../scripts/popup.js"></script>
</body>
</html>
