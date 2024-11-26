<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/supplierDetails.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <p class="page-type-banner">supplier</p>
                <div class="supplier-header">
                    <!-- <h2><?php echo htmlspecialchars($supplier['name']); ?></h2> -->
                     <h2>This shows supplier name</h2>
                    <div>
                        <!-- <a href="./editSupplier.php?supplier_id=<?php echo urlencode($supplier_id);?>" class="supplier-edit">Edit</a> -->
                        <a href="./editsupplier.php" class="supplier-edit">Edit</a>
                        <button class="delete-button" onclick="deletesupplier(<?php echo htmlspecialchars($supplier_id); ?>)">Delete</button>
                    </div>
                </div>
                <div class="page-content">
                    <div class="supplier-detail-panel">
                        <div class="supplier-info">
                            <img src="./images/image.png" alt="supplier-foto">
                            <!-- <p class="name"><?php echo htmlspecialchars($supplier['name']); ?></p>
                            <p class="email"><?php echo htmlspecialchars($supplier['email']); ?></p>
                            <p class="supplier_id"><?php echo htmlspecialchars($supplier_id); ?></p> -->
                            <p class="name">This shows supplier name</p>
                            <p class="email">supplier@mail.com</p>
                            <p class="supplier_id">supplier id shows here</p>
                        </div>
                        <div class="supplier-stats">
                            <p class="stat-title">Registered</p>
                            <!-- <p class="stat-value"><?php echo htmlspecialchars($time_ago)?></p> -->
                             <p class="stat-value">Registered time upto now</p>
                            <p class="stat-title">Last delivery</p>
                            <p class="stat-value">1 hour ago</p>
                            <p class="stat-title">Total deliveries</p>
                            <p class="stat-value">32</p>
                        </div>
                    </div>
                    <div class="work-panel">
                        <div class="delivery-table">
                            <h3>Deliveries</h3>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="order-no" onclick="window.location.href='orderDetails.php?order_id=%23RT0923'">#RT0923</td>
                                        <td style="color: red">To be delivered before</td>
                                        <td>February 21, 2025</td>
                                        <td>$ 170.00</td>
                                    </tr>
                                    <tr>
                                        <td class="order-no" onclick="window.location.href='orderDetails.php?order_id=%23RD1243'">#RD1243</td>
                                        <td style="color: green">Delivered on</td>
                                        <td>February 21, 2025</td>
                                        <td>$ 540.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="contact-details">
                            <h3>Contact details</h3>
                            <p class="detail-title">Address</p>
                            <!-- <p class="detail-value"><?php echo htmlspecialchars($supplier['address']) ?></p> -->
                            <p class="detail-value">supplier's address</p>
                            <p class="detail-title">Telephone number</p>
                            <!-- <p class="detail-value"><?php echo htmlspecialchars($supplier['phone']) ?></p> -->
                             <p class="detail-value">supplier's telephone no</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>