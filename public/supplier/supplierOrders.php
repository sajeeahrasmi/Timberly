<?php include '../../api/fetchApprovedOrders.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Supplier Orders</title>
    <link rel="stylesheet" href="/Supplier/styles/index.css">
    <link rel="stylesheet" href="styles/supplierOrders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="orders-content">
        <h1>Supplier Order Section</h1>

        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>No. of Items</th>
                        <th>Date</th>
                        <th>Post Status</th>
                        <th>Action</th>
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
                                <td><?= date("d/m/Y", strtotime($order['postdate'])) ?></td>
                                <td class="po"><?= ($order['is_approved'] = '1') ? 'Approved' : 'Pending' ?></td>
                                <td><span style="cursor:pointer"><i class="fa-solid fa-eye"></i></span></td>
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
