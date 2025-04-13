<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="styles/supplierOrders.css">
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
    <div class="orders-content">
        <h1>Supplier Order Section</h1>
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
