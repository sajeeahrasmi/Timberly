<?php
require '../config/db_connection.php'; // adjust path as needed

$year = $_POST['year'] ?? date('Y');
$month = $_POST['month'] ?? null;

$filter = $month ? "$year-$month%" : "$year%";
$period = $month ? date("F Y", strtotime("$year-$month-01")) : $year;

// Total orders
$totalOrdersSql = "SELECT COUNT(*) AS totalOrders FROM orders WHERE date LIKE ?";
$stmt1 = $conn->prepare($totalOrdersSql);
$stmt1->bind_param("s", $filter);
$stmt1->execute();
$totalOrders = $stmt1->get_result()->fetch_assoc()['totalOrders'] ?? 0;

// Total sales amount
$totalSalesSql = "SELECT SUM(totalAmount) AS totalSales FROM orders WHERE date LIKE ?";
$stmtSales = $conn->prepare($totalSalesSql);
$stmtSales->bind_param("s", $filter);
$stmtSales->execute();
$totalSales = $stmtSales->get_result()->fetch_assoc()['totalSales'] ?? 0;

// Category-wise orders
$categorySql = "SELECT category, COUNT(*) AS count FROM orders WHERE date LIKE ? GROUP BY category";
$stmt2 = $conn->prepare($categorySql);
$stmt2->bind_param("s", $filter);
$stmt2->execute();
$categoryData = $stmt2->get_result();
$categories = [];
while ($row = $categoryData->fetch_assoc()) {
    $categories[] = $row;
}

// Total sales per category
$salesSql = "SELECT category, SUM(totalAmount) AS total FROM orders WHERE date LIKE ? GROUP BY category";
$stmt3 = $conn->prepare($salesSql);
$stmt3->bind_param("s", $filter);
$stmt3->execute();
$salesData = $stmt3->get_result();
$salesByCategory = [];
while ($row = $salesData->fetch_assoc()) {
    $salesByCategory[] = $row;
}

// Total payments received
$paymentSql = "SELECT SUM(amount) AS totalReceived FROM payment WHERE orderId IN (SELECT orderId FROM orders WHERE date LIKE ?)";
$stmt4 = $conn->prepare($paymentSql);
$stmt4->bind_param("s", $filter);
$stmt4->execute();
$totalReceived = $stmt4->get_result()->fetch_assoc()['totalReceived'] ?? 0;

// Order count by status
$statusSql = "SELECT status, COUNT(*) AS count FROM orders WHERE date LIKE ? GROUP BY status";
$stmt5 = $conn->prepare($statusSql);
$stmt5->bind_param("s", $filter);
$stmt5->execute();
$statusData = $stmt5->get_result();
$statuses = [];
while ($row = $statusData->fetch_assoc()) {
    $statuses[] = $row;
}

// Calculate balance (not yet received)
$balance = $totalSales - $totalReceived;
?>

<h3>Sales Report for <?= htmlspecialchars($period) ?></h3>

<div class="summary-cards">
    <div class="summary-card">
        <h4>Total Orders</h4>
        <p><?= number_format($totalOrders) ?></p>
    </div>
    
    <div class="summary-card">
        <h4>Total Sales</h4>
        <p>Rs <?= number_format($totalSales, 2) ?></p>
    </div>
    
    <div class="summary-card">
        <h4>Payments Received</h4>
        <p>Rs <?= number_format($totalReceived, 2) ?></p>
    </div>
    
    <div class="summary-card">
        <h4>Outstanding Balance</h4>
        <p>Rs <?= number_format($balance, 2) ?></p>
    </div>
</div>

<div class="report-section">
    <h4>Orders by Category</h4>
    <div class="category-data">
        <?php foreach ($categories as $cat): ?>
            <div class="category-item">
                <h5><?= htmlspecialchars($cat['category']) ?></h5>
                <p><?= number_format($cat['count']) ?> orders</p>
            </div>
        <?php endforeach; ?>
        <?php if (empty($categories)): ?>
            <p>No order data available for this period.</p>
        <?php endif; ?>
    </div>
</div>

<div class="report-section">
    <h4>Sales by Category</h4>
    <div class="category-data">
        <?php foreach ($salesByCategory as $sale): ?>
            <div class="category-item">
                <h5><?= htmlspecialchars($sale['category']) ?></h5>
                <p>Rs <?= number_format($sale['total'], 2) ?></p>
            </div>
        <?php endforeach; ?>
        <?php if (empty($salesByCategory)): ?>
            <p>No sales data available for this period.</p>
        <?php endif; ?>
    </div>
</div>

<div class="report-section">
    <h4>Orders by Status</h4>
    <div class="category-data">
        <?php foreach ($statuses as $status): ?>
            <div class="category-item">
                <h5><?= htmlspecialchars($status['status']) ?></h5>
                <p><?= number_format($status['count']) ?></p>
            </div>
        <?php endforeach; ?>
        <?php if (empty($statuses)): ?>
            <p>No status data available for this period.</p>
        <?php endif; ?>
    </div>
</div>

<div class="report-section">
    <h4>Detailed Order Summary</h4>
    <?php if ($totalOrders > 0): ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Orders</th>
                    <th>Sales Amount</th>
                    <th>% of Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salesByCategory as $idx => $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['category']) ?></td>
                        <td><?= isset($categories[$idx]) ? number_format($categories[$idx]['count']) : 'N/A' ?></td>
                        <td>Rs <?= number_format($sale['total'], 2) ?></td>
                        <td><?= $totalSales > 0 ? number_format(($sale['total'] / $totalSales) * 100, 1) . '%' : '0%' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found for this period.</p>
    <?php endif; ?>
</div>