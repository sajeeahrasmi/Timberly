<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/home.css">
        <script src="./scripts/home.js"></script>
    </head>
    <body>
        <div class="main-content">
            <div class="dashboard">
                <div class="card">
                    <div class="card-stats">
                        <h6>Total Orders</h6>
                        <p>6</p>
                        <button onclick="showSection('order-section')"> <i class="fa-solid fa-eye" style="margin: 7px;"></i>View Orders</button>
                    </div>
                    <i class="fa-solid fa-bag-shopping fa-2xl"></i>
                </div>
                <div class="card">
                    <div class="card-stats">
                        <h6>Total Suppliers</h6>
                        <p>15</p>
                        <button onclick="showSection('supplier-section')"> <i class="fa-solid fa-eye" style="margin: 7px;"></i> View Suppliers</button>
                    </div>
                    <i class="fa-solid fa-user-tie fa-2xl"></i>
                </div>
                <div class="card">
                    <div class="card-stats">
                        <h6>Total Customers</h6>
                        <p>900</p>
                        <button onclick="showSection('customer-section')"> <i class="fa-solid fa-eye" style="margin: 7px;"></i>View Customers</button>
                    </div>
                    <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                </div>
                <div class="card">
                    <div class="card-stats">
                        <h6>Total Posts</h6>
                        <p>100</p>
                        <button onclick="showSection('createPost-section')"> <i class="fa-solid fa-circle-plus" style="margin: 7px;"></i>Create a Post</button>
                    </div>
                    <i class="fa-regular fa-clipboard fa-2xl"></i>
                </div>
            </div>
        </div>
    </body>
</html>