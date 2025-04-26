
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