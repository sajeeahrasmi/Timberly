<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly-Admin</title>

    <link rel="stylesheet" href="../styles/components/sidebar.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>

</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="./images/logo.png" alt="Logo" style="height: 60px;" />
            <h2>Timberly</h2>
        </div>
        <hr>
        
        <nav>
            <ul >

                <li><a href="#" onclick="checkAndShowSection('dashboard-section')"><i class="fa-solid fa-house icon"></i>Dashboard</a></li>
                <li><a href="#" onclick="checkAndShowSection('postProducts-section')"><i class="fa-solid fa-rectangle-list icon"></i>Post</a></li>
                <li><a href="#" onclick="checkAndShowSection('order-section')"><i class="fa-solid fa-list-check"></i>Order</a></li>
                <li><a href="#" onclick="checkAndShowSection('inventory-section')"><i class="fa-solid fa-boxes-stacked" style="margin-right: 12px"></i>Inventory</a></li>
                <li><a href="#" onclick="checkAndShowSection('customer-section')"><i class="fa-solid fa-users"></i>Customer</a></li>
                <li><a href="#" onclick="checkAndShowSection('supplier-section')"><i class="fa-solid fa-user-tie" style="margin-left: 2px; margin-right: 14px"></i>Supplier</a></li>
                <li><a href="#" onclick="checkAndShowSection('designer-section')"><i class="fa-solid fa-brush" style="margin-left: 3px; margin-right: 15px"></i>Designer</a></li>
                <li><a href="#" onclick="checkAndShowSection('driver-section')"><i class="fa-solid fa-truck" style="margin-left: 1px; margin-right: 10px"></i>Driver</a></li>
                <!-- <li class="logout"><a href="#" onclick="showSection('logout-section')"><i class="fa-solid fa-right-from-bracket icon"></i>Logout</a></li> -->
                <li class="logout"><a href="#" onclick="window.location.href=`http://localhost/Timberly/config/logout.php`"><i class="fa-solid fa-right-from-bracket icon"></i>Logout</a></li>

                
            </ul>
        </nav>
    </aside>
    <script src="../scripts/components/sidebar.js" defer></script>
</body>
</html>

<script src="../scripts/components/sidebar.js" defer></script>


