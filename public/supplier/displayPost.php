<?php 
include '../../api/displayPost.php'; // Include the PHP file that handles the logic
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/index.css">
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

        <div class="tab-header">
            <button class="tab-btn" data-tab="timber" onclick="showTab('timber')">Timber</button>
            <button class="tab-btn" data-tab="lumber" onclick="showTab('lumber')">Lumber</button>
        </div>

        <div id="timber" class="tab-content" style="display: none;">
            <div class="metric-grid">
                <?php while ($row = mysqli_fetch_assoc($timberResult)) {
                    displayPostCard($row, 'timber');
                } ?>
            </div>
        </div>

        <div id="lumber" class="tab-content" style="display: none;">
            <div class="metric-grid">
                <?php while ($row = mysqli_fetch_assoc($lumberResult)) {
                    displayPostCard($row, 'lumber');
                } ?>
            </div>
        </div>

        <div class="metric-grid">
            <?php
            function displayPostCard($row, $type) {
                $imagePath = $row['image'];
                $fileExt = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png'];
                $category = $type;
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
                        <h6>Price per Unit: <?php echo $row['unitprice']; ?> LKR</h6>
                        <h6>Total Price: <?php echo $row['totalprice']; ?> LKR</h6>
                        <h6>Post Date: <?php echo $row['postdate']; ?></h6>
                        <h6>Additional Information: <?php echo $row['info']; ?></h6>

                        <div class="buttons">
                            <a href="#" onclick="confirmUpdate(<?php echo $row['id']; ?>, '<?php echo $category; ?>'); return false;">
                                <button title="Update">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </a>

                            <a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>, '<?php echo $category; ?>'); return false;">
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

<script src="scripts/displayPost.js"></script>

</body>
</html>
