<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>

    <style>
        /* General Styles */
:root {
    /* CSS Variables */
    --color-primary: #895D47;
    --color-secondary: #D2B48C;
    --color-white: #fff;
    --color-background: #f0f2f5;
    --color-text: #333;
    --color-text-light: #666;
    --box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    --border-radius-1: 4px;
    --border-radius-2: 8px;
    --border-radius-3: 10px;
    --card-padding: 1.5rem;
    --padding: 1rem;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #f0f2f5;
    color: #333;
    line-height: 1.6;
    padding: 30px;
    max-width: 100%;
    overflow-x: hidden;
}

.sales-report-container {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin: 2rem auto;
    max-width: 1200px;
    border: 3px solid #895D47;
}

.sales-report-container h2 {
    color: #895D47;
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 15px;
    border-bottom: 3px solid #895D47;
    font-size: 1.8rem;
}

/* Filters */
.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 2rem;
    justify-content: center;
    align-items: flex-end;
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
}

.filters label {
    color: #333;
    font-weight: bold;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 16px;
}

.filters select,
.filters input[type="month"],
.filters input[type="number"] {
    padding: 12px 24px;
    border-radius: 30px;
    border: 2px solid #895D47;
    font-size: 16px;
    background-color: white;
    color: #333;
    min-width: 180px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.filters select:focus,
.filters input:focus {
    outline: none;
    border-color: #895D47;
    box-shadow: 0 0 0 2px rgba(137, 93, 71, 0.2);
}

.filters button {
    background-color: #895D47;
    color: white;
    border: 2px solid #895D47;
    padding: 12px 24px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s, border-color 0.3s, color 0.3s;
}

.filters button:hover {
    background-color: white;
    color: #895D47;
    border-color: #895D47;
    transform: translateY(-2px);
}

/* Summary Cards */
.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.summary-card {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
    border: 1px solid #895D47;
    
}

.summary-card:hover {
    transform: translateY(-5px);
}

.summary-card h4 {
    margin: 0;
    color: #895D47;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.summary-card p {
    margin: 0;
    font-size: 1.3rem;
    color: #333;
    font-weight: bold;
}

/* Report Sections */
.report-section {
    margin-bottom: 2rem;
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
}

.report-section h4 {
    color: #895D47;
    font-size: 1.2rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #895D47;
}

/* Category Data */
.category-data {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.category-item {
    padding: 15px;
    background-color: #f9f5f2;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #e0e0e0;
}

.category-item h5 {
    font-size: 1rem;
    margin-bottom: 0.5rem;
    color: #666;
}

.category-item p {
    font-size: 1.2rem;
    font-weight: bold;
    color: #895D47;
}

/* Tables */
.report-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
    border-radius: 8px;
    overflow: hidden;
}

.report-table thead {
    background-color: #895D47;
    color: white;
}

.report-table th,
.report-table td {
    padding: 18px 12px;
    border: 1px solid #e0e0e0;
    text-align: left;
}

.report-table tbody tr:nth-child(even) {
    background-color: #f9f5f2;
}

.report-table tbody tr:hover {
    background-color: #f2e7e3;
}

/* Buttons */
.button {
    padding: 12px 24px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.button.outline {
    background-color: transparent;
    color: #895D47;
    border-color: #895D47;
}

.button.outline:hover {
    background-color: #895D47;
    color: white;
}

.button.solid {
    background-color: #895D47;
    color: white;
    border-color: #895D47;
}

.button.solid:hover {
    background-color: white;
    color: #895D47;
}

/* Report Results */
#reportResults {
    margin-top: 2rem;
}

#reportResults h3 {
    color: #895D47;
    text-align: center;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    padding-bottom: 10px;
    border-bottom: 2px solid #895D47;
}

.report-overview {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.report-overview p {
    background-color: white;
    padding: 15px;
    border-radius: 8px;
    flex: 1;
    min-width: 200px;
    font-weight: 600;
    text-align: center;
    border-left: 3px solid #895D47;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.report-overview strong {
    color: #895D47;
}

/* Download PDF Button */
.download-pdf-container {
    margin: 15px 0;
    text-align: right;
}

.pdf-button {
    background-color: #895D47;
    color: white;
    border: 2px solid #895D47;
    padding: 12px 24px;
    border-radius: 30px;
    cursor: pointer;
    font-size: 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s, transform 0.2s, border-color 0.3s, color 0.3s;
}

.pdf-button:hover {
    background-color: white;
    color: #895D47;
    border-color: #895D47;
    transform: translateY(-2px);
}

.pdf-button:disabled {
    background-color: #cccccc;
    border-color: #cccccc;
    color: #666;
    cursor: not-allowed;
    transform: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filters {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filters div {
        width: 100%;
    }
    
    .summary-cards {
        grid-template-columns: 1fr;
    }
    
    .category-data {
        grid-template-columns: 1fr;
    }
    
    .report-overview {
        flex-direction: column;
    }
    
    body {
        padding: 15px;
    }
    
    .sales-report-container {
        padding: 20px;
    }
}
    </style>
</head>

<body>
    <div class="sales-report-container">
        <h2>Sales Report</h2>
        <form id="reportForm" class="filters">
            <div>
                <label for="year">Year:</label>
                <select id="year" name="year"></select>
            </div>
        
            <div>
                <label for="month">Month (optional):</label>
                <select id="month" name="month">
                    <option value="">All Months</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
        
            <div>
                <button type="submit">Generate Report</button>
            </div>
        </form>
      
        <div id="reportResults">
            <!-- AJAX report results will appear here -->
        </div>
        <div class="download-pdf-container">
            <button id="download-pdf-btn" type="button" class="pdf-button">
                <i class="fa fa-download"></i> Download PDF
            </button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const yearSelect = document.getElementById("year");
            const currentYear = new Date().getFullYear();
            
            for (let y = currentYear; y >= currentYear - 5; y--) {
                const opt = document.createElement("option");
                opt.value = y;
                opt.textContent = y;
                yearSelect.appendChild(opt);
            }

            document.getElementById("reportForm").addEventListener("submit", function (e) {
                e.preventDefault();

                const year = document.getElementById("year").value;
                const month = document.getElementById("month").value;

                fetch("../../api/sales.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `year=${year}&month=${month}`
                })
                .then(res => res.text())
                .then(data => {
                    document.getElementById("reportResults").innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching report:', error);
                    document.getElementById("reportResults").innerHTML = 
                        `<p style="color: red; text-align: center">Error generating report. Please try again.</p>`;
                });
            });

            document.getElementById("download-pdf-btn").addEventListener("click", downloadSalesReportPDF);
        });

        // Add this script to your existing JavaScript or as a new file
function downloadSalesReportPDF() {
    const reportContent = document.getElementById('reportResults');
    if (!reportContent.innerHTML.trim()) {
        alert('Please generate a report first');
        return;
    }

    // Show loading indicator
    const button = document.getElementById('download-pdf-btn');
    const originalText = button.textContent;
    button.disabled = true;
    button.textContent = 'Generating PDF...';

    // Get report period for the filename
    const reportTitle = reportContent.querySelector('h3')?.textContent || 'Sales Report';
    const fileName = reportTitle.replace(/[^a-z0-9]/gi, '_').toLowerCase() + '.pdf';
    
    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Add title
        doc.setFontSize(16);
        doc.text(reportTitle, 105, 15, null, null, 'center');
        
        // Add summary cards
        const summaryCards = reportContent.querySelectorAll('.summary-card');
        if (summaryCards.length) {
            let yPos = 25;
            doc.setFontSize(12);
            
            summaryCards.forEach((card, index) => {
                const title = card.querySelector('h4').textContent;
                const value = card.querySelector('p').textContent;
                doc.text(`${title}: ${value}`, 20, yPos);
                yPos += 8;
            });
        }
        
        // Add category data
        const reportSections = reportContent.querySelectorAll('.report-section');
        if (reportSections.length) {
            let yPos = 60;
            
            reportSections.forEach((section) => {
                // Add section title
                const sectionTitle = section.querySelector('h4').textContent;
                doc.setFontSize(13);
                doc.setFont(undefined, 'bold');
                doc.text(sectionTitle, 20, yPos);
                doc.setFont(undefined, 'normal');
                doc.setFontSize(10);
                yPos += 8;
                
                // Add table if present
                const table = section.querySelector('table');
                if (table) {
                    // Get table headers
                    const headers = Array.from(table.querySelectorAll('th')).map(th => th.textContent);
                    
                    // Get table rows
                    const rows = Array.from(table.querySelectorAll('tbody tr')).map(tr => 
                        Array.from(tr.querySelectorAll('td')).map(td => td.textContent)
                    );
                    
                    // Calculate column widths
                    const colWidths = [50, 30, 50, 40]; // Adjust as needed
                    
                    // Draw headers
                    doc.setFont(undefined, 'bold');
                    let xPos = 20;
                    headers.forEach((header, i) => {
                        doc.text(header, xPos, yPos);
                        xPos += colWidths[i];
                    });
                    yPos += 7;
                    doc.setFont(undefined, 'normal');
                    
                    // Draw rows
                    rows.forEach(row => {
                        // Check if we need a new page
                        if (yPos > 270) {
                            doc.addPage();
                            yPos = 20;
                        }
                        
                        xPos = 20;
                        row.forEach((cell, i) => {
                            doc.text(cell, xPos, yPos);
                            xPos += colWidths[i];
                        });
                        yPos += 7;
                    });
                    
                    yPos += 10;
                } else {
                    // Add category items if no table
                    const categoryItems = section.querySelectorAll('.category-item');
                    if (categoryItems.length) {
                        let xPos = 20;
                        let itemCount = 0;
                        
                        categoryItems.forEach((item, index) => {
                            // Start a new row after every 3 items
                            if (itemCount % 3 === 0 && itemCount > 0) {
                                xPos = 20;
                                yPos += 20;
                            }
                            
                            // Check if we need a new page
                            if (yPos > 270) {
                                doc.addPage();
                                yPos = 20;
                                xPos = 20;
                            }
                            
                            const title = item.querySelector('h5').textContent;
                            const value = item.querySelector('p').textContent;
                            
                            doc.setFont(undefined, 'bold');
                            doc.text(title, xPos, yPos);
                            doc.setFont(undefined, 'normal');
                            doc.text(value, xPos, yPos + 6);
                            
                            xPos += 70;
                            itemCount++;
                        });
                        
                        yPos += 25;
                    }
                }
            });
        }
        
        // Generate and save PDF
        doc.save(fileName);
    } catch (error) {
        console.error('Error generating PDF:', error);
        alert('Failed to generate PDF. Please check console for errors.');
    } finally {
        // Reset button
        button.disabled = false;
        button.textContent = originalText;
    }
}
    </script>
</body>
</html>