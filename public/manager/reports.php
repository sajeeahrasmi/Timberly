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
    <title>Business Reports - Timberly</title>
    <link rel="stylesheet" href="./styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    
</head>
<body>
<div class="content">
      <div class="reports-section">
       <div class="titleOverview"> <h2>Overview</h2> </div>
        
        <div class="metric-grid">
          <div class="metric-card">
            <h3>Total Revenue</h3>
            <div class="metric-content">
              <span class="metric-value">Rs.25,000</span> 
              <i class="fas fa-dollar-sign"></i>
            </div>
            <button onclick="generateRevenueReport()">
              <i class="fas fa-file-invoice-dollar"></i>
              Generate Revenue Report
            </button>
          </div>
          
          <div class="metric-card">
            <h3>Total Orders</h3>
            <div class="metric-content">
              <span class="metric-value">1,500</span>
              <i class="fas fa-shopping-bag"></i>
            </div>
            <button onclick="generateOrderReport()">
              <i class="fas fa-file-alt"></i>
              Generate Order Report
            </button>
          </div>
          
          
        </div>

        <div class="report-details">
          <div class="report-section">
            <h2>Inventory Summary</h2>
            <table class="styled-table">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Total Items</th>
                  <th>In Stock</th>
                  <th>Low Stock</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Furniture</td>
                  <td>250</td>
                  <td>180</td>
                  <td>70</td>
                </tr>
                <tr>
                  <td>Raw Materials</td>
                  <td>500</td>
                  <td>350</td>
                  <td>150</td>
                </tr>
                <tr>
                  <td>Doors</td>
                  <td>100</td>
                  <td>80</td>
                  <td>20</td>
                </tr>
                <tr>
                  <td>Windows</td>
                  <td>75</td>
                  <td>60</td>
                  <td>15</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="report-section">
            <div class="titleRevenue"><h2>Revenue Breakdown</h2></div>
            <table class="styled-table">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Total Sales</th>
                  <th>% of Total Revenue</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Furniture</td>
                  <td>Rs.12,500</td>
                  <td>50%</td>
                </tr>
                <tr>
                  <td>Doors</td>
                  <td>Rs.6,250</td>
                  <td>25%</td>
                </tr>
                <tr>
                  <td>Windows</td>
                  <td>Rs.3,750</td>
                  <td>15%</td>
                </tr>
                <tr>
                  <td>Raw Materials</td>
                  <td>Rs.2,500</td>
                  <td>10%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function generateRevenueReport() {
      alert('Generating detailed revenue report...');
      
    }

    function generateOrderReport() {
      alert('Generating comprehensive order report...');
      
    }

    function generateProductReport() {
      alert('Generating product category breakdown...');
      
    }
  </script>
</body>
</html>