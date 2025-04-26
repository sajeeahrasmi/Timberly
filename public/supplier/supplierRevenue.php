<?php
include '../../api/fetchApprovedOrders.php';

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/index.css"> 
    <link rel="stylesheet" href="styles/supplierRevenue.css"> 
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="body-content">
    <div class="dashboard-content">

        
        <div class="metric-grid">
            <div class="metric-card">
            <h3>Total Revenue: Rs. <?= number_format($totalRevenue, 2) ?></h3>

                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <div class="metric-card">
                <h3>Timber Revenue: Rs. <?= number_format($timberRevenue, 2) ?></h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <div class="metric-card">
                <h3>Lumber Revenue: Rs. <?= number_format($lumberRevenue, 2) ?></h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <div class="filter-container">
        <form id="filterForm" class="filter-form">
            <label>Select Month:
                <input type="month" name="from" value="<?= $_GET['from'] ?? '' ?>" class='filter-select'>
            </label>

            <label>Category:
                <select name="category" class='filter-select'>
                    <option value="">All</option>
                    <option value="Timber">Timber</option>
                    <option value="Lumber">Lumber</option>
                </select>
            </label>
            <label>Type: <input type="text" name="type" value="<?= $_GET['type'] ?? '' ?>" class='filter-select'
            ></label>
            <button type="submit" class='filter-btn'>Filter</button>
            <button type="button" id="resetBtn" class='filter-btn' >Reset</button>
        </form>
        
        <button type="button" id="exportPdfBtn" class="filter-btn">Export to PDF</button>


        </div>

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
                <tbody id="orderTableBody">
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

<script src="scripts/supplierRevenue.js"></script>

</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

