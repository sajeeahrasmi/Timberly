<?php
// Mock data for suppliers
$rawData = [
    ['raw_id' => '#QA159', 'date' => 'May 15, 2021', 'product' => 'Mahogani', 'category' => 'Timber', 'u_price' => '$15.90', 'availability' => 'Out of stock', 'quantity' => 0],
    ['raw_id' => '#WE159', 'date' => 'February 26, 2021', 'product' => 'Thekka', 'category' => 'Lumber', 'u_price' => '$8.90', 'availability' => 'In stock', 'quantity' => 2],
    ['raw_id' => '#ZA159', 'date' => 'August 5, 2020', 'product' => 'Kaluwara', 'category' => 'Timber', 'u_price' => '$28.90', 'availability' => 'Out of stock', 'quantity' => 0],
    ['raw_id' => '#KQ159', 'date' => 'December 31, 2021', 'product' => 'Thekka', 'category' => 'Timber', 'u_price' => '$20.90', 'availability' => 'In stock', 'quantity' => 3]
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
        <link rel="stylesheet" href="postRaw.css">
    </head>
    <body>       
        <div class="page-content">            
            <div class="main-content">
                <h3><span class="passive-category"><a href="#" onclick="showSection('postProducts-section')">Products</a></span><span class="active-category"> | Raw materials</span></h3>
                <div class="product-display-box">
                    <p>posts</p>
                    <div class="content-header">
                        <h2>Raw Materials</h2>
                        <a href="./createPost.php"><i class="fa-solid fa-circle-plus" style="margin-right: 8px"></i>Create a post</a>
                    </div>

                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Unit price</th>
                                <th>Availability</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rawData as $item): ?>
                            <tr onclick="window.location.href='/admin/productEdit.php';">
                                <td><?php echo $item['raw_id']; ?></td>
                                <td><?php echo $item['date']; ?></td>
                                <td><?php echo $item['product']; ?></td>
                                <td><?php echo $item['category']; ?></td>
                                <td><?php echo $item['u_price']; ?></td>
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