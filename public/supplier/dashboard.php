<?php 
include '../../api/fetchDashboardData.php'; // Include the dashboard data fetching script

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/index.css">
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
                            <td class="po"><?= ($order['status'] = 'Approved') ? 'Approved' : 'Pending' ?></td>
                            <td>
                                <span class="view-btn"
                                    data-id="<?= htmlspecialchars($order['id']) ?>"
                                    data-category="<?= htmlspecialchars($order['category']) ?>"
                                    data-type="<?= htmlspecialchars($order['type']) ?>"
                                    data-quantity="<?= htmlspecialchars($order['quantity']) ?>"
                                    data-date="<?= date("d/m/Y", strtotime($order['postdate'])) ?>"
                                    data-status="<?= $order['status'] == 'Approved' ? 'Approved' : 'Pending' ?>"
                                    style="cursor:pointer">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </td>

                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Container -->
<div id="orderModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h3>Order Details</h3>
    <div id="modalDetails"></div>
  </div>
</div>


</body>

<script>
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const modal = document.getElementById('orderModal');
        const details = document.getElementById('modalDetails');

        // Populate modal details
        details.innerHTML = `
            <p><strong>Post ID:</strong> ${btn.dataset.id}</p>
            <p><strong>Category:</strong> ${btn.dataset.category}</p>
            <p><strong>Type:</strong> ${btn.dataset.type}</p>
            <p><strong>No. of Items:</strong> ${btn.dataset.quantity}</p>
            <p><strong>Date:</strong> ${btn.dataset.date}</p>
            <p><strong>Status:</strong> ${btn.dataset.status}</p>
        `;

        modal.style.display = 'flex'; // Show modal
    });
});

// Close button
document.querySelector('.close-btn').addEventListener('click', () => {
    document.getElementById('orderModal').style.display = 'none';
});

// Optional: Close modal when clicking outside content
window.addEventListener('click', (e) => {
    const modal = document.getElementById('orderModal');
    if (e.target === modal) modal.style.display = 'none';
});
</script>

</html>
