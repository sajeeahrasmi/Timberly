<?php
    include '../../api/getDrivers.php';
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly Ltd</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/drivers.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div class="drivers-display-box">
                    <div style="display: flex;
                                justify-content: space-between;
                                align-items: center;"
                        class="content-header">
                        <h2>Drivers</h2>
                        <a class="add-driver-button" href="./addDriver.php"><i class="fa-solid fa-circle-plus" style="margin-right: 8px"></i>Add Driver</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Driver ID</th>
                                <th>Name</th>
                                <th>Vehicle No</th>
                                <th>Registered on</th>
                                <th>Telephone no</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($driverData as $item): ?>
                                <tr onclick="window.location.href='./driverDetails.php?driver_id=<?php echo urlencode($item['driver_id']); ?>'">
                                    <td><?php echo $item['driver_id']; ?></td>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['vehicleNo']; ?></td>
                                    <td><?php echo $item['registered_on']; ?></td>
                                    <td><?php echo $item['tele_num']; ?></td>
                                    <td><?php echo $item['email']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </body>
</html>