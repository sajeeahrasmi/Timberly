<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';

// Rest of your existing PHP code follows...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="./styles/admin.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="./scripts/admin.js" defer></script>
    <style>
      
    </style>
</head>
<body>

  <div class="admin-container">
    
    <div class="top-bar">
    <h1>Welcome Manager!</h1>
      <div class="user-actions">
      <button class="notification-btn" onclick="window.location.href='supplierNotification.php';"><i class="fas fa-bell"></i></button>
        <button class="profile-btn"  onclick="openProfileModal()" ><i class="fas fa-user"></i></button>
      </div>
    </div>

   
    <aside class="sidebar">
    
  <div class="logo">
  <img src="./images/final_logo.png" alt="Logo" style="height: 200px; margin: 0%; padding: 0%;"  />
  </div>
  <hr>
  <nav>
    <ul>
    <li><a href="#" onclick="showSection('dashboard-section')"><i class="fa-solid fa-house icon"></i>Dashboard</a></li>
<li><a href="#" onclick="showSection('products-section')"><i class="fa-solid fa-tree icon"></i>Products</a></li>
<li><a href="#" onclick="showSection('orders-section')"><i class="fa-solid fa-chair icon"></i>Orders</a></li>
<li><a href="#" onclick="showSection('inventory-section')"><i class="fa-solid fa-box icon"></i>Inventory</a></li>
<li><a href="#" onclick="showSection('report-section')"><i class="fas fa-chart-line icon"></i>Reports</a></li>

      
    </ul>
    
  </nav>
  <div class="logout">
      <form action="logout.php" method="POST">
        <button type="submit"><i class="fa-solid fa-right-from-bracket icon"></i>Logout</button>
      </form>
    </div>
</aside>


    
    <div class="content">
      <div id="dashboard-section" class="section">
        <h2>Dashboard Overview</h2>
        <div class="metric-grid">
            
            <div class="metric-card">
    <h3>Total Revenue</h3>
    <div class="metric-content">
        <span class="metric-value">Rs.25,000</span> 
        <i class="fas fa-dollar-sign"></i>
    </div>
    <button onclick="showSection('report-section')">
        <i class="fas fa-eye"></i>
        View Revenue
    </button>
</div>
            <div class="metric-card">
                <h3>Total Orders</h3>
                <div class="metric-content">
                    <span class="metric-value">1500</span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <button onclick="showSection('orders-section')">
                    <i class="fas fa-eye"></i>
                    View Orders
                </button>
            </div>
            
            
            <div class="metric-card">
                <h3>Total Posts</h3>
                <div class="metric-content">
                    <span class="metric-value">100</span>
                    <i class="fas fa-clipboard"></i>
                </div>
                <button onclick="showSection('products-section'); showTab('furniture')";>
                    <i class="fas fa-plus"></i>
                    Create Post
                </button>
            </div>
            
        </div>

       
        <div class="textt"><h2>Pending Orders</h2></div>
            <table class="styled-table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Order ID</th>
                    <th>Order Details</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="orders-tbody">
            
            </tbody>
        </table>
      </div>
      
      <div id="products-section" class="section">
        <?php include 'products.php';?>
      </div>
      <div id="orders-section" class="section"><?php include 'orders.php'; ?>
    </div>
      <div id="inventory-section" class="section"><?php include 'inventory.php'; ?></div>
      <div id="report-section" class="section">
            <?php  include 'reports.php'; ?>
            
     
</div>
<div id="profile-modal" class="profile-modal-overlay">
        <div class="profile-modal-content">
            <button class="profile-close-btn" onclick="closeProfileModal()"><span class="profile-close-modal">&times;</span></button>
            <h3>Manager Profile</h3>
            <form id="profile-form">
                <input type="text" id="name" placeholder="Name" value="Rishi Rasheen" required>
                <input type="email" id="email" placeholder="Email" value="rasheen25@gmail.com" required>
                <input type="password" id="new-password" placeholder="New Password" required>
                <input type="password" id="confirm-password" placeholder="Confirm New Password" required>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>


</body>


</html>





