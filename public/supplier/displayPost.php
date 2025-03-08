<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="/Supplier/styles/displayPost.css"> <!-- Link to your CSS file -->
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

</body>
</html>
