<?php 
    include '../../api/getDriverDetails.php';
    include '../../api/deleteDriver.php';
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/driverDetails.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <p class="page-type-banner">driver</p>
                <div class="driver-header">
                    <h2><?php echo htmlspecialchars($driver['name']); ?></h2>
                    <div>
                        <a href="./editDriver.php?driver_id=<?php echo urlencode($driver_id);?>" class="driver-edit">Edit</a>
                        <button class="delete-button" onclick="deleteDriver(<?php echo htmlspecialchars($driver_id); ?>)">Delete</button>
                    </div>
                </div>
                <div class="page-content">
                    <div class="driver-detail-panel">
                        <div class="driver-info">
                            <img src="./images/image.png" alt="driver-foto">
                            <p class="name"><?php echo htmlspecialchars($driver['name']); ?></p>
                            <p class="email"><?php echo htmlspecialchars($driver['email']); ?></p>
                            <p class="driver_id"><?php echo htmlspecialchars($driver_id); ?></p>
                            <p class="vehicleNo"><?php echo htmlspecialchars($driver['vehicleNo'])?></p>
                        </div>
                        <div class="driver-stats">
                            <p class="stat-title">Registered</p>
                            <p class="stat-value"><?php echo htmlspecialchars($time_ago)?></p>
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
                            <p class="detail-value"><?php echo htmlspecialchars($driver['address']) ?></p>
                            <p class="detail-title">Telephone number</p>
                            <p class="detail-value"><?php echo htmlspecialchars($driver['phone']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </body>
    <script src="./scripts/deleteDriver.js"></script>
</html>