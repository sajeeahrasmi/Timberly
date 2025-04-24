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
    <div class="dashboard-content">
        <div class="top">
            <h1>Monthly Revenue</h1>
        </div>
        
        <div class="metric-grid">
            <!-- Total Orders Card -->
            <div class="metric-card">
                <h3>Total Revenue</h3>
                <div class="metric-content">
                    <span class="metric-value">42580</span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Approved Orders Card -->
            <div class="metric-card">
                <h3>Timber Revenue</h3>
                <div class="metric-content">
                    <span class="metric-value">26980</span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="metric-card">
                <h3>Lumber Revenue</h3>
                <div class="metric-content">
                    <span class="metric-value">15600</span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
