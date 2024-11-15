<?php
// Mock data for suppliers
$productData = [
    ['prod_id' => '#QA159', 'date' => 'May 15, 2021', 'product' => 'Square legged Table', 'category' => 'Table', 'price' => '$198.90', 'availability' => 'Out of stock', 'quantity' => 0],
    ['prod_id' => '#WE159', 'date' => 'February 26, 2021', 'product' => 'Triple door Cupboard', 'category' => 'Cupboard', 'price' => '$298.90', 'availability' => 'In stock', 'quantity' => 2],
    ['prod_id' => '#ZA159', 'date' => 'August 5, 2020', 'product' => 'Metalizable Pantry', 'category' => 'Pantry', 'price' => '$498.90', 'availability' => 'Out of stock', 'quantity' => 0],
    ['prod_id' => '#KQ159', 'date' => 'December 31, 2021', 'product' => 'Library stool chair', 'category' => 'Chair', 'price' => '$158.90', 'availability' => 'In stock', 'quantity' => 3]
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
    </head>
    <body>
        <div class="page-content">
            <div class="main-content">
                <h3><span class="active-category">Products</span> |<span class="passive-category"><a href="#" onclick="showSection('postRaw-section')">Raw materials</a></span></h3>
                <div class="product-display-box">
                    <p>posts</p>
                    <div class="content-header">
                        <h2>Products</h2>
                        <a href="/Admin/createPost.php">Create a post</a>
                    </div>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Availability</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productData as $item): ?>
                            <tr onclick="window.location.href='/admin/productEdit.php';">
                                <td><?php echo $item['prod_id']; ?></td>
                                <td><?php echo $item['date']; ?></td>
                                <td><?php echo $item['product']; ?></td>
                                <td><?php echo $item['category']; ?></td>
                                <td><?php echo $item['price']; ?></td>
                                <td><?php echo $item['availability']; ?></td>
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