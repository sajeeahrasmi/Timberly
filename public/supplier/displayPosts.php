<?php 
include '../../config/db_connection.php'; // Include your database connection

// Fetch posts from database
$sql = "SELECT * FROM crudpost";
$result = mysqli_query($conn, $sql);

// Handle delete request
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $delete_sql = "DELETE FROM crudpost WHERE id = $post_id";
    if (mysqli_query($conn, $delete_sql)) {
        // Redirect to prevent re-execution on refresh
        header("Location: displayPost.php?message=Post deleted successfully");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css">
    <link rel="stylesheet" href="/Supplier/styles/displayPost.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <!-- Sidebar -->
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="body-content">
        <?php if (isset($_GET['message'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

        <div class="metric-grid">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="metric-card">
                    <?php 
                    $image = $row['image'];
                    $imagePath = "./Uploads/" . $image;
                    
                    if (file_exists($imagePath) && in_array(strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) { ?>
                        <img src="<?php echo $imagePath; ?>" alt="Post Image" class="metric-img">
                    <?php } else { ?>
                        <p>No image available or unsupported format.</p>
                    <?php } ?>

                    <div class="metric-details">
                        <h3>Post Id: <?php echo $row['id']; ?></h3>
                        <h6>Category: <?php echo $row['category']; ?></h6>
                        <h6>Type: <?php echo $row['type']; ?></h6>
                        <h6>Length: <?php echo $row['length']; ?> m</h6>
                        <h6>Width: <?php echo $row['width']; ?> mm</h6>
                        <h6>Height: <?php echo $row['height']; ?> mm</h6>
                        <h6>Quantity: <?php echo $row['quantity']; ?></h6>
                        <h6>Price per Unit: <?php echo $row['price']; ?></h6>
                        <h6>Additional Information: <?php echo $row['info']; ?></h6>

                        <div class="buttons">
                            <a href="updatePost.php?id=<?php echo $row['id']; ?>">
                                <button title="Update">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </a>
                            <a href="displayPost.php?delete=true&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                                <button title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>
