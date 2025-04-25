<?php
include '../../api/fetchApprovedOrders.php'; // Include the dashboard data fetching script

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="styles/dashboard.css"> <!-- Link to your CSS file -->

</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<!-- Wrap Sidebar and Body in .body-container -->
<div class="body-container">
    <!-- Sidebar -->
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <!-- Main Content Area -->
    <div class="body-content">
    <!-- Main Content Area -->
    <div class="dashboard-content">
        <!-- <div class="top">
            <h1>Dashboard</h1>
        </div> -->
        
        <div class="metric-grid">
            <!-- Total Orders Card -->
            <div class="metric-card">
                <h3>Total Revenue</h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Approved Orders Card -->
            <div class="metric-card">
                <h3>Timber Revenue</h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="metric-card">
                <h3>Lumber Revenue</h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <form method="GET" class="filter-form">
    <label>Category:
        <select name="category">
            <option value="">All</option>
            <option value="Timber" <?= ($_GET['category'] ?? '') === 'Timber' ? 'selected' : '' ?>>Timber</option>
            <option value="Lumber" <?= ($_GET['category'] ?? '') === 'Lumber' ? 'selected' : '' ?>>Lumber</option>
        </select>
    </label>
    <label>Type:
        <input type="text" name="type" value="<?= htmlspecialchars($_GET['type'] ?? '') ?>">
    </label>
    <label>From:
        <input type="date" name="from" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
    </label>
    <label>To:
        <input type="date" name="to" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
    </label>
    <button type="submit">Filter</button>
</form>


        <div class="table-container">
            <table class="styled-table">
            <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Post Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['category']) ?></td>
                                <td><?= htmlspecialchars($order['type']) ?></td>
                                <td><?= htmlspecialchars($order['quantity']) ?></td>
                                <td><?= htmlspecialchars($order['unitprice']) ?></td>
                                <td><?= htmlspecialchars($order['totalprice']) ?></td>
                                <td><?= date("d/m/Y", strtotime($order['postdate'])) ?></td>
                                <td class="po"><?= ($order['is_approved'] = '1') ? 'Approved' : 'Pending' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center;">No approved orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
