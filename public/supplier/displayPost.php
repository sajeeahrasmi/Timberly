<?php 
include '../../config/db_connection.php';
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'supplier') {
    header("Location: /Supplier/login.php");
    exit();
}

// Display PHP errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Queries for both lumber and timber posts
$lumberQuery = "SELECT * FROM pendinglumber WHERE supplierId = '{$_SESSION['userId']}' AND is_approved = '0'";
$timberQuery = "SELECT * FROM pendingtimber WHERE supplierId = '{$_SESSION['userId']}' AND is_approved = '0'";

$lumberResult = mysqli_query($conn, $lumberQuery);
$timberResult = mysqli_query($conn, $timberQuery);

// Handle delete request
if (isset($_GET['delete']) && isset($_GET['id']) && isset($_GET['type'])) {
    $post_id = intval($_GET['id']);
    $type = $_GET['type'];

    if ($type === 'lumber') {
        $delete_sql = "DELETE FROM pendinglumber WHERE id = $post_id";
    } elseif ($type === 'timber') {
        $delete_sql = "DELETE FROM pendingtimber WHERE id = $post_id";
    }

    if (isset($delete_sql) && mysqli_query($conn, $delete_sql)) {
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
    <link rel="stylesheet" href="styles/displayPost.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="display-content">
        <?php if (isset($_GET['message'])): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

        <!-- Tab Headers -->
<div class="tab-header">
    <button class="tab-btn active" onclick="showTab('timber')">Timber</button>
    <button class="tab-btn" onclick="showTab('lumber')">Lumber</button>
</div>

        <div class="metric-grid">
            <?php
            // Function to display a post card
            function displayPostCard($row, $type) {
                $imagePath= $row['image'];
                //$imagePath = "/Supplier/uploads/" . $image;
                $fileExt = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png'];
                $category = $type; // 'lumber' or 'timber'
                //echo $imagePath;
                ?>

                <div class="metric-card">
                    <?php if (!empty($imagePath) && in_array($fileExt, $allowedExts)): ?>
                        <img src="../<?php echo $imagePath; ?>" alt="Post Image" class="metric-img">
                    <?php else: ?>
                        <p>No image available or unsupported image format.</p>
                    <?php endif; ?>

                    <div class="metric-details">
                        <h3>Post Id: <?php echo $row['id']; ?></h3>
                        <h6>Category: <?php echo ucfirst($category); ?></h6>
                        <h6>Type: <?php echo $row['type']; ?></h6>

                        <?php if ($category === 'lumber'): ?>
                            <h6>Length: <?php echo $row['length']; ?> m</h6>
                            <h6>Width: <?php echo $row['width']; ?> mm</h6>
                            <h6>Thickness: <?php echo $row['thickness']; ?> mm</h6>
                        <?php elseif ($category === 'timber'): ?>
                            <h6>Diameter: <?php echo $row['diameter']; ?> mm</h6>
                        <?php endif; ?>

                        <h6>Quantity: <?php echo $row['quantity']; ?></h6>
                        <h6>Price per Unit: <?php echo $row['unitprice']; ?></h6>
                        <h6>Additional Information: <?php echo $row['info']; ?></h6>

                        <div class="buttons">
                            <a href="updatePost.php?id=<?php echo $row['id']; ?>&category=<?php echo $category; ?>">
                                <button title="Update">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </a>
                            <a href="displayPost.php?delete=true&id=<?php echo $row['id']; ?>&type=<?php echo $category; ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                                <button title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <!-- Display lumber posts -->
           <!-- Tab Headers -->



<!-- Timber Tab Content -->
<div id="timber" class="tab-content" style="display: none;">
    <div class="metric-grid">
        <?php while ($row = mysqli_fetch_assoc($timberResult)) {
            displayPostCard($row, 'timber');
        } ?>
    </div>
</div>


<!-- Lumber Tab Content -->
<div id="lumber" class="tab-content" style="display: block;">
    <div class="metric-grid">
        <?php while ($row = mysqli_fetch_assoc($lumberResult)) {
            displayPostCard($row, 'lumber');
        } ?>
    </div>
</div>

        </div>
    </div>
</div>
<script>
function showTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });

    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show the selected tab and mark the button active
    document.getElementById(tabId).style.display = 'block';
    document.querySelector(`.tab-btn[onclick="showTab('${tabId}')"]`).classList.add('active');
}
</script>

</body>
</html>
