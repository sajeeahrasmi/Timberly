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
                    <div class="metric-card ">
                        <h3>Total Orders</h3>
                        <div class="metric-content">
                            <span class="metric-value">8</span>
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <a href="../Backend/display.php">
                            <button onclick="showSection('orders-section')">
                            <i class="fas fa-eye"></i>
                            View Orders
                        </button>
                    </a>
                        
                    </div>

                    <div class="metric-card">
                        <h3>Approved Orders</h3>
                        <div class="metric-content">
                            <span class="metric-value">4</span>
                            <i class="fas fa-shopping-bag"></i>
                        </div><a href="../Posts/approved.html">
                            <button onclick="showSection('orders-section')">
                                <i class="fas fa-eye"></i>
                                View Orders
                            </button>

                        </a>
                        
                    </div>

                    <div class="metric-card">
                        <h3>Pending Orders</h3>
                        <div class="metric-content">
                            <span class="metric-value">4</span>
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <a href="../Posts/pending.html">
                            <button onclick="showSection('orders-section')">
                                <i class="fas fa-eye"></i>
                                View Orders
                            </button>
                        </a>
                        
                    </div>

                </div>

                <div class="top">
                    <h2>Recent Orders</h2>
                </div>

                <!-- <div class="bottom">
                    <div class="popup" id="view-post-popup">
                        <div class="popup-wrapper">
                            <div class="popup-header">
                                <h3 class="popup-title" style="color:var(--color-primary)">View Post Details</h3>
                                <button class="popup-close-button" data-close-popup style="color:var(--color-primary)"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="popup-content"> -->
                                <!-- Replace this content dynamically with post details if needed -->
                                <!-- <p><strong>Post ID:</strong> <span id="view-post-id"></span></p>
                                <p><strong>Category:</strong> <span id="view-post-category"></span></p>
                                <p><strong>Type:</strong> <span id="view-post-type"></span></p>
                                <p><strong>No. of Items:</strong> <span id="view-post-items"></span></p>
                                <p><strong>Date:</strong> <span id="view-post-date"></span></p>
                                <p><strong>Post Status:</strong> <span id="view-post-status"></span></p>
                                <p><strong>Payment Status:</strong> <span id="view-post-payment-status"></span></p>
                            </div>
                        </div> -->
                    <!-- </div> -->
                    <div class="table-container">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Post ID</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>No.of Items</th>
                                    <th>Date</th>
                                    <th>Post Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>4</td>
                                    <td>Timber</td>
                                    <td>Mahogani</td>
                                    <td>4</td>
                                    <td>28/11/2024</td>
                                    <td class="po">Successful</td>
                                    <td class="py">Complete</td>
                                    <td>
                                        <span style="cursor:pointer"><i class="fa-solid fa-eye"></i></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Timber</td>
                                    <td>Jak</td>
                                    <td>5</td>
                                    <td>28/11/2024</td>
                                    <td class="po">Successful</td>
                                    <td class="py">Complete</td>
                                    <td>
                                        <span style="cursor:pointer"><i class="fa-solid fa-eye"></i></span>

                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Timber</td>
                                    <td>Teak</td>
                                    <td>12</td>
                                    <td>27/11/2024</td>
                                    <td class="po">Successful</td>
                                    <td class="py">complete</td>

                                    <td>
                                        <span style="cursor:pointer"><i class="fa-solid fa-eye"></i></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Lumber</td>
                                    <td>Cinamond</td>
                                    <td>11</td>
                                    <td>26/11/2024</td>
                                    <td class="po">Successful</td>
                                    <td class="py">complete</td>
                                    <td>
                                        <span style="cursor:pointer"><i class="fa-solid fa-eye"></i></span>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    </div>
</div>

</body>
</html>
