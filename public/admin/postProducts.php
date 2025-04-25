<?php
    include '../..api/auth.php';
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
        <div style="position: fixed">
            <?php include "./components/sidebar.php" ?> 
        </div>
        <div class="main-content" style="margin-left: 300px">
            <?php include "./components/header.php" ?>
            <h3><span class="active-category">Products</span> |<span class="passive-category"><a href="postRawLumber.php">Raw materials</a></span></h3>
            <div class="product-display-box">
                <p>posts</p>
                <div class="content-header">
                    <h2 style="margin-bottom: 0px">Products</h2>
                </div>
                <div class="filter-division">
                        <input type="text" id="searchProductID" placeholder="Filter by ProductID" class="filters">
                        <input type="text" id="searchCategory" placeholder="Filter by Category" class="filters">
                        <input type="text" id="searchType" placeholder="Filter by Type" class="filters">
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
<script>
    document.getElementById('searchProductID').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            const productId = row.children[0].textContent.toLowerCase();
            row.style.display = productId.includes(filter) ? '' : 'none';
        });
    });
    document.getElementById('searchCategory').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            const category = row.children[2].textContent.toLowerCase();
            row.style.display = category.includes(filter) ? '' : 'none';
        });
    });
    document.getElementById('searchType').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            const type = row.children[3].textContent.toLowerCase();
            row.style.display = type.includes(filter) ? '' : 'none';
        });
    });
</script>
</html>
