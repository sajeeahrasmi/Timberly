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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

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

        <

          <div class="report-section">
            <div class="titleRevenue"><h2>Revenue Breakdown</h2></div>
            <table class="styled-table">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Total Sales</th>
                  
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Furniture</td>
                  <td>Rs.12,500</td>
                 
                </tr>
                <tr>
                  <td>Doors</td>
                  <td>Rs.6,250</td>
                  
                </tr>
                <tr>
                  <td>Windows</td>
                  <td>Rs.3,750</td>
                  
                </tr>
                <tr>
                  <td>Raw Materials</td>
                  <td>Rs.2,500</td>
                 
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

    async function generateOrderReport() {
  try {
    const response = await fetch('../../api/reportOrder.php');
    const data = await response.json();

    const completedOrders = data.filter(order => order.status === 'Completed');

    if (completedOrders.length === 0) {
      alert('No completed orders found.');
      return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Completed Orders Report", 14, 15);

    // Convert data into rows for the table
    const tableData = completedOrders.map(order => [
      order.orderId,
      order.customer,
      order.total,
      order.date
    ]);

    doc.autoTable({
      head: [['Order ID', 'Customer', 'Total', 'Date']],
      body: tableData,
      startY: 20
    });

    doc.save("CompletedOrdersReport.pdf");
  } catch (error) {
    console.error('Error:', error);
    alert('Failed to generate report.');
  }
}


  </script>
</body>
</html>