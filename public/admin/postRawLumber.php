<?php
    include '../..api/auth.php';
    include '../../api/getPostRawLumber.php';
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
                    <h3><span class="active-category">Lumber </span> |<span class="passive-category"><a href="postRawTimber.php">Timber</a></span></h3>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Type</th>
                                <th style="text-align: right">Length(cm)</th>
                                <th style="text-align: right">Width(cm)</th>
                                <th style="text-align: right">Thickness(mm)</th>
                                <th>Quantity</th>
                                <th>Availability</th>
                                <th style="text-align: right">Unit price (Rs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productData as $item): ?>

                            <tr onclick="window.location.href='./lumberDetails.php?lumberId=<?php echo urlencode($item['lumberId']); ?>'">
                                <td><?php echo $item['lumberId']; ?></td>
                                <td><?php echo $item['type']; ?></td>
                                <td style="text-align: right"><?php echo $item['length']?></td>
                                <td style="text-align: right"><?php echo $item['width']?></td>
                                <td style="text-align: right"><?php echo $item['thickness']?></td>
                                <td style="text-align: right"><?php echo $item['qty']; ?></td>
                                <td>
                                    <?php 
                                    if ($item['qty'] > 0) {
                                        echo "In Stock";
                                    } else {
                                        echo "Out of Stock";
                                    }
                                    ?>
                                </td>
                                <td style="text-align: right"><?php echo $item['unitPrice']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>">&laquo; Prev</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>