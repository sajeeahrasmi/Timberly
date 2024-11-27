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
                width = '$width', height = '$height', quantity = '$quantity', 
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
            <h3 class="popup-title">Notifications</h3>
            <button class="popup-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="popup-content">
            <button class="popup-trigger" data-popup-id="not-1">Show Notification 1</button>
            <button class="popup-trigger" data-popup-id="not-2">Show Notification 2</button>
            <button class="popup-trigger" data-popup-id="not-3">Show Notification 3</button>
        </div>
    </div>
</div>
<div class="popup" id="not-1">
    <div class="popup-wrapper">
        <div class="popup-header">
            <h3 class="popup-title">Notification 1</h3>
            <button class="popup-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="popup-content">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat minus, assumenda laudantium dolore
            deserunt dolor ut illo rerum, esse pariatur, iste maiores hic laboriosam accusamus porro tempora
            veritatis quibusdam est?
        </div>
    </div>
</div>
<div class="popup" id="not-2">
    <div class="popup-wrapper">
        <div class="popup-header">
            <h3 class="popup-title">Notification 2</h3>
            <button class="popup-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="popup-content">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat minus, assumenda laudantium dolore
            deserunt dolor ut illo rerum, esse pariatur, iste maiores hic laboriosam accusamus porro tempora
            veritatis quibusdam est?
        </div>
    </div>
</div>
<div class="popup" id="not-3">
    <div class="popup-wrapper">
        <div class="popup-header">
            <h3 class="popup-title">Notification 3</h3>
            <button class="popup-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="popup-content">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat minus, assumenda laudantium dolore
            deserunt dolor ut illo rerum, esse pariatur, iste maiores hic laboriosam accusamus porro tempora
            veritatis quibusdam est?
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
                <a href="../Dashboard/dashboard.html" class="sidebar-link">Dashboard</a>
                <a href="../Backend/create.php" class="sidebar-link">Create Post</a>
                <a href="../Posts/total.html" class="sidebar-link active">Supplier Posts</a>
                <a href="../Posts/approved.html" class="sidebar-link">Supplier Orders</a>
                <a href="../Update Profile/updateprofile.html" class="sidebar-link">User Profile</a>
                <a href="#" class="sidebar-link">Log Out</a>
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
                            <label for="length">Length(cm):</label>
                            <input type="number" name="length" value="<?php echo htmlspecialchars($length); ?>" required>

                            <label for="width">Width(cm):</label>
                            <input type="number" name="width" value="<?php echo htmlspecialchars($width); ?>" required>

                            <label for="height">Height(cm):</label>
                            <input type="number" name="height" value="<?php echo htmlspecialchars($height); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>
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
