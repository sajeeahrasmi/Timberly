<?php 
    include '../..api/auth.php';
    include '../../api/getOrdersByAdmin.php';
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/orders.css">
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
                <div class="orders-display-box">
                    <h2>Customer Orders</h2>
                    <div class="filter-division">
                        <input type="text" id="searchOrderID" placeholder="Filter by Order ID" class="filters">
                        <input type="text" id="searchCategory" placeholder="Filter by Category" class="filters">
                        <input type="text" id="searchType" placeholder="Filter by Status" class="filters">
                        <input type="number" id="searchAmount" placeholder="Min Amount" class="filters">
                        <button class="filters-button" onclick="filterByAmount()">Filter</button>
                    </div>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer name</th>
                                <th class="order-amount">Amount(Rs)</th>
                                <th>Category</th>
                                <th>Order status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderData as $order): ?>
                            <tr onclick="window.location.href='./orderDetails.php?order_id=<?php echo urlencode($order['order_id']); ?>'">
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['date']); ?></td>
                                <td><?php echo htmlspecialchars($order['customerName']); ?></td>
                                <?php $order['totalAmount']=number_format($order['totalAmount'] ,2)?>
                                <td class="order-amount"><?php echo htmlspecialchars($order['totalAmount']); ?></td>
                                <td><?php echo htmlspecialchars($order['category']); ?></td>
                                <td class="order-status"><?php echo htmlspecialchars($order['orderStatus']); ?></td>
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
    document.getElementById('searchOrderID').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            const orderId = row.children[0].textContent.toLowerCase();
            row.style.display = orderId.includes(filter) ? '' : 'none';
        });
    });
    document.getElementById('searchCustomer').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            const customerName = row.children[2].textContent.toLowerCase();
            row.style.display = customerName.includes(filter) ? '' : 'none';
        });
    });
    document.getElementById('searchCategory').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            const category = row.children[4].textContent.toLowerCase();
            row.style.display = category.includes(filter) ? '' : 'none';
        });
    });
    document.getElementById('searchStatus').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-table tbody tr');

        rows.forEach(row => {
            const status = row.children[5].textContent.toLowerCase();
            row.style.display = status.includes(filter) ? '' : 'none';
        });
    });
    function filterByAmount() {
        const amount = document.getElementById('searchAmount').value;
        window.location.href = `?minAmount=${amount}`;
    }
</script>
</html>