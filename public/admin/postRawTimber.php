<?php
    include '../..api/auth.php';
    include '../../api/getPostRawTimber.php';
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
        <link rel="stylesheet" href="./styles/postRawLumber.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>            
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <h3><span class="passive-category"><a href="postProducts.php">Products</a></span><span class="active-category"> | Raw materials</span></h3>
                <div class="product-display-box">
                    <p>posts</p>
                    <div class="content-header">
                        <h2>Raw Materials</h2>
                    </div>
                    <h3><span class="passive-category"><a href="postRawLumber.php">Lumber</a></span> |<span class="active-category">Timber</span></h3>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Type</th>
                                <th>Diameter(cm)</th>
                                <th>SupplierId</th>
                                <th>Quantity</th>
                                <th>Availability</th>
                                <th style="text-align: right">Unit price (Rs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productData as $item): ?>

                            <tr onclick="window.location.href='./timberDetails.php?timberId=<?php echo urlencode($item['timberId']); ?>'">
                                <td><?php echo $item['timberId']; ?></td>
                                <td><?php echo $item['type']; ?></td>
                                <td><?php echo $item['diameter']?></td>
                                <td><?php echo $item['supplierId']?></td>
                                <td><?php echo $item['qty']; ?></td>
                                <td>
                                    <?php 
                                    if ($item['qty'] > 0) {
                                        echo "In Stock";
                                    } else {
                                        echo "Out of Stock";
                                    }
                                    ?>
                                </td>
                                <td style="text-align: right"><?php echo $item['price']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>