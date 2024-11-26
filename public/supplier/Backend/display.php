<?php
include 'db.php'; // Ensure you have the correct database connection

$sql = "SELECT * FROM crudpost"; // Query to get posts
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Error fetching posts: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Posts</title>
    <link rel="stylesheet" href="../styles/globals.css">
    <link rel="stylesheet" href="../styles/layout.css">
    <link rel="stylesheet" href="../Posts/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
</head>
<body>
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
                <a href="../Backend/display.php" class="sidebar-link active">Supplier Posts</a>
                <a href="../Posts/approved.html" class="sidebar-link">Supplier Orders</a>
                <a href="../Update Profile/updateprofile.html" class="sidebar-link">User Profile</a>
                <a href="#" class="sidebar-link">Log Out</a>
            </div>
        </div>

        <div class="body-content-container">
            <div class="body-content">
                <div class="metric-grid">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="metric-card">
                            <?php 
                            // Get image path from the database
                            $image = $row['image']; // Image filename from the database
                            $imagePath = "../uploads/" . $image; // Correct the image path here

                            // Debugging output
                            // echo "Image Path: " . $imagePath . "<br>"; // Debugging line to see the image path
                            // Check if image exists and is either JPG or PNG
                            if (file_exists($imagePath) && in_array(strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) { ?>
                                <img src="<?php echo $imagePath; ?>" alt="Post Image" class="metric-img">
                            <?php } else { ?>
                                <p>No image available or unsupported image format.</p>
                            <?php } ?>

                            <div class="metric-details">
                                <h3>Post Id: <?php echo $row['id']; ?></h3>
                                <h6>Category: <?php echo $row['category']; ?></h6>
                                <h6>Type: <?php echo $row['type']; ?></h6>
                                <h6>Length: <?php echo $row['length']; ?> cm</h6>
                                <h6>Width: <?php echo $row['width']; ?> cm</h6>
                                <h6>Height: <?php echo $row['height']; ?> cm</h6>
                                <h6>Quantity: <?php echo $row['quantity']; ?></h6>
                                <h6>Additional Information: <?php echo $row['info']; ?></h6>

                                <div class="buttons">
                                    <a href="update.php?id=<?php echo $row['id']; ?>">
                                        <button>
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    </a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                                        <button>
                                            <i class="fa-solid fa-trash"></i>  Delete
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../scripts/popup.js"></script>
</body>
</html>
