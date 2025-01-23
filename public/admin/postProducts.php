<?php
// Mock data for suppliers
$productData = [
    ['prod_id' => '#QA159', 'date' => 'May 15, 2021', 'product' => 'Square legged Table', 'category' => 'Table', 'price' => '198.90', 'quantity' => 0],
    ['prod_id' => '#WE159', 'date' => 'February 26, 2021', 'product' => 'Triple door Cupboard', 'category' => 'Cupboard', 'price' => '298.90', 'quantity' => 2],
    ['prod_id' => '#ZA159', 'date' => 'August 5, 2020', 'product' => 'Metalizable Pantry', 'category' => 'Pantry', 'price' => '498.90', 'quantity' => 0],
    ['prod_id' => '#KQ159', 'date' => 'December 31, 2021', 'product' => 'Library stool chair', 'category' => 'Chair', 'price' => '158.90', 'quantity' => 3]
];
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
            <h3><span class="active-category">Products</span> |<span class="passive-category"><a href="postRaw.php">Raw materials</a></span></h3>
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
                            <th>Date</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price(Rs.)</th>
                            <th>Availability</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productData as $item): ?>
                        <tr onclick="window.location.href='./productDetails.php?prod_id=<?php echo urlencode($item['prod_id']); ?>&date=<?php echo urlencode($item['date']); ?>&product=<?php echo urlencode($item['product']); ?>&category=<?php echo urlencode($item['category']); ?>&price=<?php echo urlencode($item['price']); ?>&quantity=<?php echo urlencode($item['quantity']); ?>';">
                            <td><?php echo $item['prod_id']; ?></td>
                            <td><?php echo $item['date']; ?></td>
                            <td><?php echo $item['product']; ?></td>
                            <td><?php echo $item['category']; ?></td>
                            <td style="text-align: right;"><?php echo $item['price']; ?></td>
                            <td>
                                <?php 
                                if ($item['quantity'] > 0) {
                                    echo "In Stock";
                                } else {
                                    echo "Out of Stock";
                                }
                                ?>
                            </td>
                            <td><?php echo $item['quantity']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
