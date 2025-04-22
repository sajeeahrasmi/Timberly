<?php include '../../config/db_connection.php'; // Include your DB connection 
include '../../api/fetchDashboardData.php'; // Include the dashboard data fetching script

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css">
    <link rel="stylesheet" href="/Supplier/styles/dashboard.css"> <!-- Link to your CSS file -->
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
    <div class="dashboard-content">
        <div class="top">
            <h1>Dashboard</h1>
        </div>
        
        <div class="metric-grid">
            <!-- Total Orders Card -->
            <div class="metric-card">
                <h3>Total Orders</h3>
                <div class="metric-content">
                    <span class="metric-value"><?= $totalOrders ?></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Approved Orders Card -->
            <div class="metric-card">
                <h3>Approved Orders</h3>
                <div class="metric-content">
                    <span class="metric-value"><?= $approvedOrders ?></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="metric-card">
                <h3>Pending Orders</h3>
                <div class="metric-content">
                    <span class="metric-value"><?= $pendingOrders ?></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <div class="top">
            <h2>Recent Orders</h2>
        </div>

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
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id']) ?></td>
                            <td><?= htmlspecialchars($order['category']) ?></td>
                            <td><?= htmlspecialchars($order['type']) ?></td>
                            <td><?= htmlspecialchars($order['quantity']) ?></td>
                            <td><?= date("d/m/Y", strtotime($order['postdate'])) ?></td>
                            <td class="po">Successful</td>
                            <td class="py">Complete</td>
                            <td>
                                <span style="cursor:pointer"><i class="fa-solid fa-eye"></i></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
