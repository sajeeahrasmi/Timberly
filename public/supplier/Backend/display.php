<?php
include 'db.php'; // Ensure you have the correct database connection
session_start();

$sql = "SELECT * FROM crudpost"; // Query to get posts
$posts = "SELECT * FROM crudpost WHERE supplierId = '{$_SESSION['userId']}'";

$result = mysqli_query($con, $posts);

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
            <div class="welcome"> <h3>Welcome <?php echo $_SESSION['name']; ?></h3></div>
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
                <a href="../Dashboard/dashboard.html" class="sidebar-link "><i class="fa-solid fa-house icon"></i>Dashboard</a>
                <a href="../Backend/create.php" class="sidebar-link "><i class="fa-solid fa-plus"></i>Create Post</a>
                <a href="../Backend/display.php" class="sidebar-link active"><i class="fa-solid fa-box"></i>Supplier Posts</a>
                <a href="../Posts/approved.html" class="sidebar-link"><i class="fa-solid fa-bag-shopping"></i>Supplier Orders</a>
                <a href="../Update Profile/updateprofile.html" class="sidebar-link"><i class="fas fa-user"></i>User Profile</a>
                <a href="http://localhost/Timberly/config/logout.php" class="sidebar-link"><i class="fa-solid fa-right-from-bracket icon"></i>Log Out</a>
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
                            $imagePath = "./Uploads/" . $image; // Correct the image path here
                            
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
                                <h6>Length: <?php echo $row['length'];?> m</h6>
                                <h6>Width: <?php echo $row['width']; ?> mm</h6>
                                <h6>Height: <?php echo $row['height']; ?> mm</h6>
                                <h6>Quantity: <?php echo $row['quantity']; ?></h6>
                                <h6>Price per Unit: <?php echo $row['price']; ?></h6>
                                <h6>Additional Information: <?php echo $row['info']; ?></h6>

                                <div class="buttons">
                                    <a href="update.php?id=<?php echo $row['id']; ?>">
                                        <button>
                                            <i class="fa-solid fa-pen-to-square" ></i>
                                        </button>
                                    </a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                                        <button>
                                            <i class="fa-solid fa-trash" ></i>
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
