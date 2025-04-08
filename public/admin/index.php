<?php
    include '../../api/fetchAdminIndex.php';
?>

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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-thin.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-solid.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-regular.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-light.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-thin.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-solid.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-regular.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-light.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-thin.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-regular.css"
      >

      <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-light.css"
      >

    </head>

    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div class="dashboard">
                    <div class="card">
                        <div class="card-stats">
                            <h6>Total Orders</h6>
                            <p><?php echo $totalOrders; ?></p>
                            <button onclick="window.location.href='orders.php'"> <i class="fa-solid fa-eye" style="margin: 7px;"></i>View Orders</button>
                        </div>
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div class="card">
                        <div class="card-stats">
                            <h6>Total Suppliers</h6>
                            <p><?php echo $totalSuppliers; ?></p>
                            <button onclick="window.location.href='suppliers.php'"> <i class="fa-solid fa-eye" style="margin: 7px;"></i> View Suppliers</button>
                        </div>
                        <i class="fa-light fa-user-tie fa-2xl"></i>
                    </div>
                    <div class="card">
                        <div class="card-stats">
                            <h6>Total Customers</h6>
                            <p><?php echo $totalCustomers; ?></p>
                            <button onclick="window.location.href='customers.php'"> <i class="fa-solid fa-eye" style="margin: 7px;"></i>View Customers</button>
                        </div>
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="card">
                        <div class="card-stats">
                            <h6>Total Posts</h6>
                            <p><?php echo $totalPosts; ?></p>
                            <button onclick="window.location.href='createPost.php'"> <i class="fa-solid fa-circle-plus" style="margin: 7px;"></i>Create a Post</button>
                        </div>
                        <i class="fa-light fa-clipboard"></i>
                    </div>
                </div>
            </div>
        </div>
        <div id="logout-section" class="section">
            <?php include './components/logout-popup.php' ?>
        </div>
    </body>
    <script src="./scripts/components/sidebar.js" defer></script>
</html>
