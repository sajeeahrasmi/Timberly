<?php
    include '../../api/getPostProducts.php';
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
    <link rel="stylesheet" href="./styles/postProducts.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
</head>
<body>
    <div class="dashboard-container">
        <?php include "./components/sidebar.php" ?>
        <div class="main-content">
            <?php include "./components/header.php" ?>
            <h3><span class="active-category">Products</span> |<span class="passive-category"><a href="postRawLumber.php">Raw materials</a></span></h3>
            <div class="product-display-box">
                <p>posts</p>
                <div class="content-header">
                    <h2>Products</h2>
                    <a href="./createPost.php"><i class="fa-solid fa-circle-plus" style="margin-right: 8px"></i>Create a post</a>
                </div>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Price (Rs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productData as $item): ?>
                        <tr onclick="window.location.href='./productDetails.php?furnitureId=<?php echo urlencode($item['furnitureId']); ?>'">
                            <td><?php echo $item['furnitureId']; ?></td>
                            <td><?php echo $item['description']; ?></td>
                            <td><?php echo $item['category']; ?></td>
                            <td><?php echo $item['type']; ?></td>
                            <td><?php echo $item['size']; ?></td>
                            <td style="text-align: right"><?php echo $item['unitPrice']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
