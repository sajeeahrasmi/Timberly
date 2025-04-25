<?php
include '../../api/fetchApprovedOrders.php'; // Include the dashboard data fetching script

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="styles/dashboard.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="styles/supplierRevenue.css"> <!-- Link to your CSS file -->
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<!-- Wrap Sidebar and Body in .body-container -->
<div class="body-container">
    <!-- Sidebar -->
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <!-- Main Content Area -->
    <div class="body-content">
    <!-- Main Content Area -->
    <div class="dashboard-content">
        <!-- <div class="top">
            <h1>Dashboard</h1>
        </div> -->
        
        <div class="metric-grid">
            <!-- Total Orders Card -->
            <div class="metric-card">
            <h3>Total Revenue: Rs. <?= number_format($totalRevenue, 2) ?></h3>

                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Approved Orders Card -->
            <div class="metric-card">
                <h3>Timber Revenue: Rs. <?= number_format($timberRevenue, 2) ?></h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="metric-card">
                <h3>Lumber Revenue: Rs. <?= number_format($lumberRevenue, 2) ?></h3>
                <div class="metric-content">
                    <span class="metric-value"></span>
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <div class="filter-container">
        <form id="filterForm" class="filter-form">
            <label>Select Month:
                <input type="month" name="from" value="<?= $_GET['from'] ?? '' ?>" class='filter-select'>
            </label>

            <label>Category:
                <select name="category" class='filter-select'>
                    <option value="">All</option>
                    <option value="Timber">Timber</option>
                    <option value="Lumber">Lumber</option>
                </select>
            </label>
            <label>Type: <input type="text" name="type" value="<?= $_GET['type'] ?? '' ?>" class='filter-select'
            ></label>
            <button type="submit" class='filter-btn'>Filter</button>
            <button type="button" id="resetBtn" class='filter-btn' >Reset</button>
        </form>

        <!-- <form method="GET" action="exportPdf.php">
            <input type="hidden" name="from_date" value="<?= $_GET['from_date'] ?? '' ?>">
            <input type="hidden" name="to_date" value="<?= $_GET['to_date'] ?? '' ?>">
            <input type="hidden" name="category" value="<?= $_GET['category'] ?? '' ?>">
            <input type="hidden" name="type" value="<?= $_GET['type'] ?? '' ?>">
            <button type="submit" class='filter-btn'>Export to PDF</button>
        </form> -->
        <button type="button" id="exportPdfBtn" class="filter-btn">Export to PDF</button>


        </div>




        <div class="table-container">
            <table class="styled-table">
            <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Post Status</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['category']) ?></td>
                                <td><?= htmlspecialchars($order['type']) ?></td>
                                <td><?= htmlspecialchars($order['quantity']) ?></td>
                                <td><?= htmlspecialchars($order['unitprice']) ?></td>
                                <td><?= htmlspecialchars($order['totalprice']) ?></td>
                                <td><?= date("d/m/Y", strtotime($order['postdate'])) ?></td>
                                <td class="po"><?= ($order['is_approved'] = '1') ? 'Approved' : 'Pending' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center;">No approved orders found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');
    const resetBtn = document.getElementById('resetBtn');
    const tableBody = document.getElementById('orderTableBody');

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const from = filterForm.elements['from'].value.trim(); // format: YYYY-MM
        const category = filterForm.elements['category'].value.trim().toLowerCase();
        const type = filterForm.elements['type'].value.trim().toLowerCase();

        let selectedMonth = '';
        let selectedYear = '';

        if (from) {
            [selectedYear, selectedMonth] = from.split('-'); // "2025", "04"
        }

        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length === 0) return;

            const rowCategory = cells[1].textContent.trim().toLowerCase();
            const rowType = cells[2].textContent.trim().toLowerCase();
            const rowDate = cells[6].textContent.trim(); // format: dd/mm/yyyy

            const [day, month, year] = rowDate.split('/');

            let show = true;

            // Filter by month and year
            if (from && (month !== selectedMonth || year !== selectedYear)) {
                show = false;
            }

            if (category && rowCategory !== category) show = false;
            if (type && !rowType.includes(type)) show = false;

            row.style.display = show ? '' : 'none';
        });
    });

    resetBtn.addEventListener('click', function () {
        filterForm.reset();
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => row.style.display = '');
    });
});


// document.addEventListener('DOMContentLoaded', function () {
//     const exportBtn = document.getElementById('exportPdfBtn');
//     const table = document.querySelector('.styled-table');

//     exportBtn.addEventListener('click', function () {
//         const { jsPDF } = window.jspdf;
//         const pdf = new jsPDF('l', 'pt', 'a4'); // landscape, points, A4
//         const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => row.style.display !== 'none');

//         if (visibleRows.length === 0) {
//             alert("No data to export.");
//             return;
//         }

//         // Clone table and remove hidden rows
//         const tableClone = table.cloneNode(true);
//         const cloneRows = tableClone.querySelectorAll('tbody tr');
//         cloneRows.forEach((row, index) => {
//             if (visibleRows.indexOf(table.querySelectorAll('tbody tr')[index]) === -1) {
//                 row.remove(); // remove hidden rows
//             }
//         });

//         // Temporarily add clone to DOM for rendering
//         tableClone.style.width = '100%';
//         tableClone.style.border = '1px solid #ccc';
//         tableClone.style.fontSize = '10px';
//         tableClone.style.margin = '20px 0';
//         tableClone.id = 'pdfTableClone';
//         document.body.appendChild(tableClone);

//         html2canvas(tableClone).then(canvas => {
//             const imgData = canvas.toDataURL('image/png');
//             const imgProps = pdf.getImageProperties(imgData);
//             const pdfWidth = pdf.internal.pageSize.getWidth();
//             const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

//             pdf.addImage(imgData, 'PNG', 20, 20, pdfWidth - 40, pdfHeight);
//             pdf.save('Filtered_Orders.pdf');

//             // Clean up
//             document.body.removeChild(tableClone);
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    const exportBtn = document.getElementById('exportPdfBtn');
    const table = document.querySelector('.styled-table');

    exportBtn.addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('l', 'pt', 'a4'); // landscape, points, A4
        const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => row.style.display !== 'none');

        if (visibleRows.length === 0) {
            alert("No data to export.");
            return;
        }

        // Clone table and remove hidden rows
        const tableClone = table.cloneNode(true);
        const cloneRows = tableClone.querySelectorAll('tbody tr');
        cloneRows.forEach((row, index) => {
            if (visibleRows.indexOf(table.querySelectorAll('tbody tr')[index]) === -1) {
                row.remove(); // remove hidden rows
            }
        });

        // Style the table clone for better PDF appearance
        tableClone.style.width = '100%';
        tableClone.style.borderCollapse = 'collapse';
        tableClone.style.fontSize = '10px';
        tableClone.style.margin = '20px 0';
        tableClone.id = 'pdfTableClone';
        
        // Style table headers
        const headers = tableClone.querySelectorAll('thead th');
        headers.forEach(header => {
            header.style.backgroundColor = '#B18068';
            header.style.color = 'white';
            header.style.padding = '8px';
            header.style.border = '1px solid #ddd';
            header.style.textAlign = 'center';
        });
        
        // Style table cells
        const cells = tableClone.querySelectorAll('tbody td');
        cells.forEach((cell, index) => {
            cell.style.padding = '6px';
            cell.style.border = '1px solid #ddd';
            
            // Apply zebra striping
            const rowIndex = Math.floor(index / 8); // 8 columns per row
            if (rowIndex % 2 === 0) {
                cell.style.backgroundColor = '#f9f9f9';
            } else {
                cell.style.backgroundColor = 'white';
            }
            
            // Right-align numeric columns (quantity, unit price, total price)
            if ([3, 4, 5].includes(index % 8)) {
                cell.style.textAlign = 'right';
            }
        });

        // Create a container for the report with a title
        const container = document.createElement('div');
        container.style.padding = '20px';
        container.style.backgroundColor = 'white';
        
        // Add title
        const titleDiv = document.createElement('div');
        titleDiv.innerHTML = `<h2 style="color: #B18068; margin-bottom: 5px;">Orders Report</h2>
                             <p style="color:rgb(195, 160, 143); margin-top: 0;">Generated on: ${new Date().toLocaleDateString()}</p>
                             <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">`;
        container.appendChild(titleDiv);
        container.appendChild(tableClone);
        
        // Add to DOM temporarily
        document.body.appendChild(container);
        container.style.position = 'absolute';
        container.style.left = '-9999px';

        html2canvas(container, {
            scale: 2, // Higher scale for better quality
            useCORS: true,
            logging: false
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            
            // Add title to PDF
            pdf.setFontSize(16);
            pdf.setTextColor(44, 62, 80);
            pdf.text("Orders Report", 40, 30);
            
            // Add date
            pdf.setFontSize(10);
            pdf.setTextColor(100, 100, 100);
            pdf.text(`Generated: ${new Date().toLocaleDateString()}`, pdf.internal.pageSize.width - 150, 30);
            
            // Add image with margins
            pdf.addImage(imgData, 'PNG', 20, 40, pdfWidth - 40, pdfHeight - 10);
            
            // Add page number
            pdf.setFontSize(8);
            pdf.text(`Page 1`, 20, pdf.internal.pageSize.height - 20);
            
            // Add footer
            pdf.setTextColor(150, 150, 150);
            pdf.text("Confidential - For internal use only", pdf.internal.pageSize.width / 2, pdf.internal.pageSize.height - 20, { align: 'center' });
            
            pdf.save('Orders_Report.pdf');

            // Clean up
            document.body.removeChild(container);
        });
    });
});
</script>



