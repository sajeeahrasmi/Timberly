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
            <h3>Total Revenue: Rs. <?= number_format($totalRevenue, 2) ?></h3>

                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Approved Orders Card -->
            <div class="metric-card">
                <h3>Timber Revenue: Rs. <?= number_format($timberRevenue, 2) ?></h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="metric-card">
                <h3>Lumber Revenue: Rs. <?= number_format($lumberRevenue, 2) ?></h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <!-- <form method="GET" class="filter-form">
        <label>Select Month: <input type="date" name="from_date" value="<?= $_GET['from_date'] ?? '' ?>"></label>
            <label>Category:
                <select name="category">
                    <option value="">All</option>
                    <option value="Timber" <?= ($_GET['category'] ?? '') == 'Timber' ? 'selected' : '' ?>>Timber</option>
                    <option value="Lumber" <?= ($_GET['category'] ?? '') == 'Lumber' ? 'selected' : '' ?>>Lumber</option>
                </select>
            </label>
            <label>Type: <input type="text" name="type" value="<?= $_GET['type'] ?? '' ?>"></label>
            <button type="submit">Filter</button>
            <a href="your_page.php"><button type="button">Reset</button></a>

        </form> -->

        <form id="filterForm" class="filter-form">
            <!-- <label>Select Month: <input type="date" name="from" value="<?= $_GET['from'] ?? '' ?>"></label> -->
            <label>Select Month:
                <input type="month" name="from" value="<?= $_GET['from'] ?? '' ?>">
            </label>

            <label>Category:
                <select name="category">
                    <option value="">All</option>
                    <option value="Timber">Timber</option>
                    <option value="Lumber">Lumber</option>
                </select>
            </label>
            <label>Type: <input type="text" name="type" value="<?= $_GET['type'] ?? '' ?>"></label>
            <button type="submit">Filter</button>
            <button type="button" id="resetBtn">Reset</button>
        </form>

<form method="GET" action="exportPdf.php">
    <input type="hidden" name="from_date" value="<?= $_GET['from_date'] ?? '' ?>">
    <input type="hidden" name="to_date" value="<?= $_GET['to_date'] ?? '' ?>">
    <input type="hidden" name="category" value="<?= $_GET['category'] ?? '' ?>">
    <input type="hidden" name="type" value="<?= $_GET['type'] ?? '' ?>">
    <button type="submit">Export to PDF</button>
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
</html>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');
    const resetBtn = document.getElementById('resetBtn');
    const tableBody = document.getElementById('orderTableBody');

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const from = filterForm.elements['from'].value.trim(); // format: YYYY-MM
        const category = filterForm.elements['category'].value.trim().toLowerCase();
        const type = filterForm.elements['type'].value.trim().toLowerCase();

        let selectedMonth = '';
        let selectedYear = '';

        if (from) {
            [selectedYear, selectedMonth] = from.split('-'); // "2025", "04"
        }

        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length === 0) return;

            const rowCategory = cells[1].textContent.trim().toLowerCase();
            const rowType = cells[2].textContent.trim().toLowerCase();
            const rowDate = cells[6].textContent.trim(); // format: dd/mm/yyyy

            const [day, month, year] = rowDate.split('/');

            let show = true;

            // Filter by month and year
            if (from && (month !== selectedMonth || year !== selectedYear)) {
                show = false;
            }

            if (category && rowCategory !== category) show = false;
            if (type && !rowType.includes(type)) show = false;

            row.style.display = show ? '' : 'none';
        });
    });

    resetBtn.addEventListener('click', function () {
        filterForm.reset();
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => row.style.display = '');
    });
});
</script>

