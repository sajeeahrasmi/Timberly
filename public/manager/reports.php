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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
<div class="content">
      <div class="reports-section">
       <div class="titleOverview"> <h2>Overview</h2> </div>
        
        <div class="metric-grid">
          <div class="metric-card">
            <h3>Total Revenue</h3>
            <div class="metric-content">

              <i class="fas fa-dollar-sign"></i>
            </div>
            <button onclick="generateRevenueReport()">
            <i class="fas fa-file-invoice"></i>
              Generate Revenue Report
            </button>
          </div>
          
          <div class="metric-card">
            <h3>Total Orders</h3>
            <div class="metric-content">
              
              <i class="fas fa-shopping-bag"></i>
            </div>
            <button onclick="generateOrderReport()">
              <i class="fas fa-file-alt"></i>
              Generate Order Report
            </button>
          </div>

          <div class="metric-card">
  <h3>Summary Report</h3>
  <div class="metric-content">
  <i class="fas fa-file-invoice"></i>
  </div>
  <button onclick="window.location.href='salesReport.php'">
  
  <i class="fas fa-file-invoice"></i>
    Generate Summary Report
  </button>
</div> 

          
          
          
        </div>

        <div class="revenue-breakdown-section">
      <div class="titleRevenue"><h2>Revenue Breakdown</h2></div>
      <div class="chart-container">
        
        <div id="revenue-pie-chart" style="width: 100%; height: 400px;">
  <canvas id="revenueChart" width="400" height="400"></canvas>
</div>

        </div>
      </div>

          
        </div>
      </div>
    </div>
  </div>

  <script>
 

    function drawRevenueChart(data) {
  const ctx = document.getElementById('revenueChart').getContext('2d');

  // Destroy any existing chart to avoid duplication
  if (window.revenueChartInstance) {
    window.revenueChartInstance.destroy();
  }

  const labels = data.map(item => item.category);
  const values = data.map(item => item.sales);

  window.revenueChartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Revenue (Rs)',
        data: values,
        backgroundColor: [
          '#4c816b', '#9d6d49', '#758a9f', '#c28860'
        ],
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Revenue by Category'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: value => 'Rs.' + value.toLocaleString()
          }
        }
      }
    }
  });
}

// Automatically fetch revenue breakdown on page load
document.addEventListener("DOMContentLoaded", function () {
  fetch('../../api/reportRevenue.php')
    .then(res => res.json())
    .then(data => {
      if (!data || data.length === 0) {
        data = [
          { category: 'Furniture', sales: 12500 },
          { category: 'Doors', sales: 6250 },
          { category: 'Windows', sales: 3750 },
          { category: 'Raw Materials', sales: 2500 }
        ];
      }
      drawRevenueChart(data);
    })
    .catch(err => {
      console.error("Failed to fetch chart data", err);
    });
});
    function generateRevenueReport() {
  // Fetch revenue data from the server
  fetch('../../api/reportRevenue.php')
    .then(response => response.json())
    .then(data => {
      createRevenueReport(data);
    })
    .catch(error => {
      console.error('Error fetching revenue data:', error);
      alert('Failed to generate revenue report.');
    });
}

function createRevenueReport(data) {
  // If no data or API call fails, use the data from the table as fallback
  if (!data || data.length === 0) {
    data = [
      { category: 'Furniture', sales: 12500 },
      { category: 'Doors', sales: 6250 },
      { category: 'Windows', sales: 3750 },
      { category: 'Raw Materials', sales: 2500 }
    ];
  }

  // Create the PDF with jsPDF
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // Add title and date
  const today = new Date().toLocaleDateString();
  doc.setFontSize(18);
  doc.text("Revenue Report", 105, 15, { align: 'center' });
  doc.setFontSize(10);
  doc.text(`Generated on: ${today}`, 105, 22, { align: 'center' });

  // Add table with revenue data
  const tableData = data.map(item => [
    item.category,
    `Rs.${item.sales.toLocaleString()}`
  ]);

  // Calculate total revenue
  //cal the sum as integer
  data.forEach(item => {
    item.sales = parseFloat(item.sales) || 0; // Ensure sales is a number
  });
  // Calculate total revenue
  const totalRevenue = data.reduce((acc, item) => acc + item.sales, 0
);

  // Add total revenue to the table data
  tableData.push([
    'Total',
    `Rs.${totalRevenue.toLocaleString()}`
  ]);
  // Add table to the PDF

  //const totalRevenue = data.reduce((sum, item) => sum + parseFloat(item.sales || 0), 0);

  //tableData.push(['Total', `Rs.${totalRevenue.toLocaleString()}`]);

  doc.autoTable({
    head: [['Category', 'Revenue']],
    body: tableData,
    startY: 30,
    headStyles: { fillColor: [76, 129, 107] }
  });

  // Create a bar chart visualization
  createBarChart(doc, data, 30, 100);

  // Save the PDF
  doc.save("RevenueReport.pdf");

  // Also display the report in a modal for preview
  showReportPreview(data);
}

function createBarChart(doc, data, x, y) {
  const chartWidth = 170;
  const chartHeight = 80;
  const barPadding = 10;
  const barWidth = (chartWidth - barPadding * (data.length + 1)) / data.length;
  const maxValue = Math.max(...data.map(item => item.sales));
  
  // Draw chart title
  doc.setFontSize(12);
  doc.text("Revenue by Category", x + chartWidth / 2, y, { align: 'center' });
  
  // Draw chart frame
  doc.rect(x, y + 5, chartWidth, chartHeight);
  
  // Draw the bars
  const colors = [
    [76, 129, 107],  // Green
    [157, 109, 73],  // Brown
    [117, 138, 159], // Blue
    [194, 136, 96]   // Light brown
  ];
  
  data.forEach((item, index) => {
    const barHeight = (item.sales / maxValue) * (chartHeight - 30);
    const barX = x + barPadding + index * (barWidth + barPadding);
    const barY = y + chartHeight - barHeight - 5;
    
    // Draw bar
    doc.setFillColor(...colors[index % colors.length]);
    doc.rect(barX, barY, barWidth, barHeight, 'F');
    
    // Add category label
    doc.setFontSize(8);
    doc.text(item.category, barX + barWidth / 2, y + chartHeight - 2, { align: 'center' });
    
    // Add value label
    doc.setFontSize(8);
    doc.text(`Rs.${item.sales.toLocaleString()}`, barX + barWidth / 2, barY - 2, { align: 'center' });
  });
}

function showReportPreview(data) {
  // Create modal container
  const modal = document.createElement('div');
  modal.className = 'report-modal';
  modal.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  `;

  // Create modal content
  const modalContent = document.createElement('div');
  modalContent.className = 'report-modal-content';
  modalContent.style.cssText = `
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 800px;
    max-height: 90%;
    overflow-y: auto;
    position: relative;
  `;

  // Add close button
  const closeButton = document.createElement('span');
  closeButton.className = 'report-modal-close';
  closeButton.innerHTML = '&times;';
  closeButton.style.cssText = `
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #555;
  `;
  closeButton.onclick = function() {
    document.body.removeChild(modal);
  };

  // Create chart container
  const chartContainer = document.createElement('div');
  chartContainer.id = 'revenue-chart';
  chartContainer.style.cssText = `
    width: 100%;
    height: 300px;
    margin-top: 20px;
  `;

  // Add title
  const title = document.createElement('h2');
  title.textContent = 'Revenue Breakdown';
  title.style.textAlign = 'center';

  // Add date
  const date = document.createElement('p');
  date.textContent = `Generated on: ${new Date().toLocaleDateString()}`;
  date.style.textAlign = 'center';
  date.style.color = '#666';

  // Create table
  const table = document.createElement('table');
  table.className = 'styled-table';
  table.style.cssText = `
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
  `;

  const thead = document.createElement('thead');
  const headerRow = document.createElement('tr');
  
  ['Category', 'Revenue'].forEach(text => {
    const th = document.createElement('th');
    th.textContent = text;
    th.style.cssText = `
      background-color: #895D47;
      color: white;
      padding: 10px;
      text-align: left;
    `;
    headerRow.appendChild(th);
  });
  
  thead.appendChild(headerRow);
  table.appendChild(thead);

  const tbody = document.createElement('tbody');
  
  // Add data rows
  data.forEach(item => {
    const row = document.createElement('tr');
    
    const categoryCell = document.createElement('td');
    categoryCell.textContent = item.category;
    categoryCell.style.padding = '8px';
    
    const salesCell = document.createElement('td');
    salesCell.textContent = `Rs.${item.sales.toLocaleString()}`;
    salesCell.style.padding = '8px';
    
    row.appendChild(categoryCell);
    row.appendChild(salesCell);
    tbody.appendChild(row);
  });
  
  // Add total row
  const totalRow = document.createElement('tr');
  totalRow.style.fontWeight = 'bold';
  
  const totalLabelCell = document.createElement('td');
  totalLabelCell.textContent = 'Total';
  totalLabelCell.style.padding = '8px';
  
  const totalValueCell = document.createElement('td');
  const totalRevenue = data.reduce((sum, item) => sum + item.sales, 0);
  totalValueCell.textContent = `Rs.${totalRevenue.toLocaleString()}`;
  totalValueCell.style.padding = '8px';
  
  totalRow.appendChild(totalLabelCell);
  totalRow.appendChild(totalValueCell);
  tbody.appendChild(totalRow);
  
  table.appendChild(tbody);

  // Add download button
  const downloadButton = document.createElement('button');
  downloadButton.textContent = 'Download PDF';
  downloadButton.style.cssText = `
    background-color: #4c816b;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: block;
    margin: 20px auto;
  `;
  downloadButton.onclick = function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Add title and date
    doc.setFontSize(18);
    doc.text("Revenue Report", 105, 15, { align: 'center' });
    doc.setFontSize(10);
    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 105, 22, { align: 'center' });
    
    // Add table
    const tableData = data.map(item => [item.category, `Rs.${item.sales.toLocaleString()}`]);
    tableData.push(['Total', `Rs.${totalRevenue.toLocaleString()}`]);
    
    doc.autoTable({
      head: [['Category', 'Revenue']],
      body: tableData,
      startY: 30,
      headStyles: { fillColor: [76, 129, 107] }
    });
    
    // Add chart
    createBarChart(doc, data, 30, 100);
    
    doc.save("RevenueReport.pdf");
  };

  // Assemble the modal
  modalContent.appendChild(closeButton);
  modalContent.appendChild(title);
  modalContent.appendChild(date);
  modalContent.appendChild(table);
  modalContent.appendChild(chartContainer);
  modalContent.appendChild(downloadButton);
  modal.appendChild(modalContent);
  document.body.appendChild(modal);

  // Create the chart using pure JavaScript
  createDOMChart(chartContainer, data);
}

function createDOMChart(container, data) {
  const chartContainer = document.createElement('div');
  chartContainer.style.cssText = `
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    height: 250px;
    padding: 20px 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
  `;

  // Find the maximum value for scaling
  const maxValue = Math.max(...data.map(item => item.sales));

  // Colors for the bars
  const colors = [
    '#4c816b',  // Green
    '#9d6d49',  // Brown
    '#758a9f',  // Blue
    '#c28860'   // Light brown
  ];

  // Create bars
  data.forEach((item, index) => {
    const barContainer = document.createElement('div');
    barContainer.style.cssText = `
      display: flex;
      flex-direction: column;
      align-items: center;
      width: ${100 / data.length}%;
      max-width: 100px;
    `;

    // Create the bar
    const bar = document.createElement('div');
    const barHeight = (item.sales / maxValue) * 200;
    bar.style.cssText = `
      width: 40px;
      height: ${barHeight}px;
      background-color: ${colors[index % colors.length]};
      border-radius: 4px 4px 0 0;
    `;

    // Create the value label
    const valueLabel = document.createElement('div');
    valueLabel.textContent = `Rs.${item.sales.toLocaleString()}`;
    valueLabel.style.cssText = `
      margin-bottom: 5px;
      font-size: 12px;
      font-weight: bold;
    `;

    // Create the category label
    const categoryLabel = document.createElement('div');
    categoryLabel.textContent = item.category;
    categoryLabel.style.cssText = `
      margin-top: 8px;
      font-size: 12px;
      text-align: center;
    `;

    barContainer.appendChild(valueLabel);
    barContainer.appendChild(bar);
    barContainer.appendChild(categoryLabel);
    chartContainer.appendChild(barContainer);
  });

  // Clear and append the chart
  container.innerHTML = '';
  container.appendChild(chartContainer);
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