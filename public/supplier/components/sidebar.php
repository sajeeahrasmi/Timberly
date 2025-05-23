<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly-Admin</title>

    <link rel="stylesheet" href="styles/components/sidebar.css">
    <link rel="stylesheet" href="styles/components/logout-popup.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>

</head>

    <div class="sidebar">
        <div class="logo">
            <img src="./images/final_logo.png" alt="Logo"/>
        </div>
        <hr>
        <nav>
            <ul >

                <li><a href="./dashboard.php"><i class="fa-solid fa-house icon"></i>Dashboard</a></li>
                <li><a href="./createPost.php"><i class="fa-solid fa-plus"></i>Create Post</a></li>
                <li><a href="./displayPost.php"><i class="fa-solid fa-rectangle-list icon"></i>Supplier Posts</a></li>
                <li><a href="./supplierOrders.php"><i class="fa-solid fa-list-check" style="margin-right: 12px"></i>Supplier Orders</a></li>
                <li><a href="./supplierRevenue.php"><i class="fas fa-chart-line icon"></i></i>Supplier Revenue</a></li>
                <li><a href="./rejectedPost.php"><i class="fa-solid fa-xmark"></i>Rejected Posts</a></li>
                <li><a href="./userProfile.php"><i class="fas fa-user"></i>User Profile</a></li>
                <li class="logout"><a href="#" onclick="window.location.href=`http://localhost/Timberly/config/logout.php`"><i class="fa-solid fa-right-from-bracket icon"></i>Logout</a></li>
            </ul>
        </nav>
</div>
<body>
</body>
</html>


