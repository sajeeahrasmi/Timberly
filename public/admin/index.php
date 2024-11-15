<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly-Admin</title>

    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="./scripts/components/sidebar.js" defer></script>
    <script src="./scripts/components/header.js" defer></script>
</head>

<body>
    <div class="dashboard-container">
        <?php include "./components/sidebar.php" ?>

        <div class="main-content">
            <?php include "./components/header.php" ?>
            <div class="content">
                <div id="dashboard-section" class="section">
                    <?php include './home.php'; ?>
                </div>
                <div id="order-section" class="section">
                    <?php include './orders.php';?>
                </div>
                <div id="inventory-section" class="section">
                    <?php include './inventory.php' ?>
                </div>
                <div id="customer-section" class="section">
                    <?php include './customers.php'; ?>
                </div>
                <div id="supplier-section" class="section">
                    <?php include './suppliers.php'; ?>
                </div>
                <div id="designer-section" class="section">
                    <?php include './designers.php'; ?>
                </div>
                <div id="driver-section" class="section">
                    <?php include './drivers.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="logout-section" class="section">
        <?php include './components/logout-popup.php' ?>
    </div>
</body>
</html>
