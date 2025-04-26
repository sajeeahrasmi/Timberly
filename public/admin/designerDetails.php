<?php
    include '../../api/auth.php';
    include '../../api/getDesignerDetails.php';
    include '../../api/deleteDesigner.php';
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
        <link rel="stylesheet" href="./styles/designerDetails.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <div style="position: fixed">
                <?php include "./components/sidebar.php" ?>
            </div>
            <div class="main-content" style="margin-left: 300px">
                <?php include "./components/header.php" ?>
                <p class="page-type-banner">designer</p>
                <div class="designer-header">
                    <h2 style="margin-left: 15px"><?php echo htmlspecialchars($designer['name']); ?></h2>
                    <div>
                        <a href="./editDesigner.php?designer_id=<?php echo urlencode($designer_id);?>" class="designer-edit">Edit</a>
                        <button class="delete-button" onclick="deleteDesigner(<?php echo htmlspecialchars($designer_id); ?>)">Delete</button>
                    </div>
                </div>
                <div class="page-content">
                    <div class="designer-detail-panel">
                        <div class="designer-info">
                            <div class="customer-default-icon">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <p class="name"><?php echo htmlspecialchars($designer['name']); ?></p>
                            <p class="email"><?php echo htmlspecialchars($designer['email']); ?></p>
                            <p class="designer_id"><?php echo htmlspecialchars($designer_id); ?></p>
                        </div>
                        <div class="designer-stats">
                            <p class="stat-title">Registered</p>
                            <p class="stat-value"><?php echo htmlspecialchars($time_ago)?></p>
                            <p class="stat-title">Last delivery</p>
                            <p class="stat-value">1 hour ago</p>
                            <p class="stat-title">Total deliveries</p>
                            <p class="stat-value">32</p>
                        </div>
                    </div>
                    <div class="work-panel">
                        <div class="contact-details">
                            <h3>Contact details</h3>
                            <p class="detail-title">Address</p>
                            <p class="detail-value"><?php echo htmlspecialchars($designer['address']) ?></p>
                            <p class="detail-title">Telephone number</p>
                            <p class="detail-value"><?php echo htmlspecialchars($designer['phone']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </body>
    <script src="./scripts/deleteDesigner.js"></script>
</html>