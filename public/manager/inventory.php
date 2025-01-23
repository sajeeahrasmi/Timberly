<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';

// Rest of your existing PHP code follows...
?>
<?php
    include '../../api/inventoryItems.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Container for inventory */
        #inventory-section {
            width: 98%; /* Increased width to fill more screen space */
            max-width: 1600px; /* Further widened max-width */
            background-color:  #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto; /* Reduced margin-top */
            padding: 20px; /* Reduced padding *//* Increased padding for better spacing */
            border: 2px solid #8B4513; /* Brown border around the entire inventory section */
        }

        /* Title styling */
        h1 {
            margin-bottom: 30px; /* More spacing for title */
            font-size: 16px; /* Larger font size */
            color: #333;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        /* Filter styles */
        .inventory-filter {
            margin-bottom: 30px; /* Increased bottom margin */
            text-align: left;
        }

        .inventory-filter label {
            margin-right: 10px;
            margin-left: 20px;
        }

        /* Tab styles */
        .inventory-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 30px; /* More spacing below tabs */
        }

        .inventory-tab {
            padding: 15px 30px; /* Larger tab size */
            background-color: #fff;
            border: 1px solid #ddd;
            cursor: pointer;
            margin-right: 20px; /* More space between tabs */
            transition: background-color 0.3s;
        }

        .inventory-tab.active {
            background-color: #895D47;
            color: white;
        }

        /* Table styles */
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px; /* More space above table */
            border: 2px solid #8B4513; /* Add brown border to the table */
        }

        .inventory-table th,
        .inventory-table td {
            border: 1px solid #ddd;
            padding: 20px; /* Larger padding for table cells */
            text-align: left;
            font-size: 14px; /* Larger font for readability */
            font-family: Arial, sans-serif;
        }

        .inventory-table th {
            background-color: #895D47; /* Brown background for table headers */
            color: white;
            font-family: Arial, sans-serif;
        }

        /* Action buttons styles */
        .inventory-actions {
            display: flex;
            gap: 20px;
        }

        .inventory-actions button {
            padding: 12px;
            border: 2px solid #8B4513; /* Brown border for the buttons */
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            background-color: transparent;
            color: #8B4513;
            transition: background-color 0.3s;
        }

        .inventory-actions button i {
            font-size: 14px; /* Icon size */
        }

        .inventory-actions button:hover {
            background-color: #8B4513;
            color: white;
        }

        .inventory-actions .edit:hover {
            background-color: #218838;
        }

        .inventory-actions .delete:hover {
            background-color: #ca1417;
        }

        /* Responsive design */
        @media (max-width: 1024px) {
            #inventory-section {
                width: 100%;
                padding: 25px; /* Adjusted padding for smaller screens */
            }

            .inventory-tabs {
                flex-direction: column;
            }

            .inventory-tab {
                margin-bottom: 15px;
                width: 100%;
                text-align: center;
            }

            .inventory-filter select {
                width: 100%;
            }

            .inventory-table th,
            .inventory-table td {
                padding: 15px; /* Adjusted padding for smaller screens */
                font-size: 14px; /* Adjust font size for smaller screens */
            }

            .inventory-actions button {
                font-size: 14px; /* Adjust button font size for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div id="inventory-section">
        <h1>Inventory Management</h1>

        <div class="inventory-filter">
            <label for="materialType">Filter by Material Type:</label>
            <select id="materialType" onchange="applyFilter()">
                <option value="">All</option>
                <?php foreach (array_merge($timberMaterialTypes, $lumberMaterialTypes) as $type): ?>
                    <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="inventory-tabs">
            <button class="inventory-tab active" onclick="showTab('timber')">Timber</button>
            <button class="inventory-tab" onclick="showTab('lumber')">Lumber</button>
        </div>

        <div id="timber" class="tab-content">
            <h2>Timber Inventory</h2>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Material Type</th>
                        <th>No. of Logs</th>
                        <th>Bought Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($timberData as $item): ?>
                        <tr>
                            <td><?php echo $item['material_type']; ?></td>
                            <td><?php echo $item['logs_count']; ?></td>
                            <td><?php echo $item['bought_date']; ?></td>
                            <td class="inventory-actions">
                                <button class="edit"><i class="fas fa-edit"></i> Edit</button>
                                <button class="delete"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="lumber" class="tab-content" style="display:none;">
            <h2>Lumber Inventory</h2>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Material Type</th>
                        <th>No. of Logs</th>
                        <th>Bought Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lumberData as $item): ?>
                        <tr>
                            <td><?php echo $item['material_type']; ?></td>
                            <td><?php echo $item['logs_count']; ?></td>
                            <td><?php echo $item['bought_date']; ?></td>
                            <td class="inventory-actions">
                                <button class="edit"><i class="fas fa-edit"></i> Edit</button>
                                <button class="delete"><i class="fas fa-trash-alt"></i> Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const timberData = <?php echo json_encode($timberData); ?>;
        const lumberData = <?php echo json_encode($lumberData); ?>;
        let currentFilter = '';

        function applyFilter() {
            const filterValue = document.getElementById('materialType').value;
            currentFilter = filterValue;
            renderData();
        }

        function renderData() {
          
            const timberTableBody = document.querySelector('#timber tbody');
            const lumberTableBody = document.querySelector('#lumber tbody');
            timberTableBody.innerHTML = '';
            lumberTableBody.innerHTML = '';

            
            const filteredTimber = currentFilter ? timberData.filter(item => item.material_type === currentFilter) : timberData;
            filteredTimber.forEach(item => {
                timberTableBody.innerHTML += `
                    <tr>
                        <td>${item.material_type}</td>
                        <td>${item.logs}</td>
                        <td>${item.bought_date}</td>
                        <td class="inventory-actions">
                            <button class="edit" onclick="editItem('timber', ${item.id})">Edit</button>
                            <button class="delete" onclick="deleteItem('timber', ${item.id})">Delete</button>
                        </td>
                    </tr>`;
            });

          
            const filteredLumber = currentFilter ? lumberData.filter(item => item.material_type === currentFilter) : lumberData;
            filteredLumber.forEach(item => {
                lumberTableBody.innerHTML += `
                    <tr>
                        <td>${item.material_type}</td>
                        <td>${item.logs}</td>
                        <td>${item.bought_date}</td>
                        <td class="inventory-actions">
                            <button class="edit" onclick="editItem('lumber', ${item.id})">Edit</button>
                            <button class="delete" onclick="deleteItem('lumber', ${item.id})">Delete</button>
                        </td>
                    </tr>`;
            });
        }

        function showTab(tabName) {
            const tabs = document.getElementsByClassName('tab-content');
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].style.display = 'none';
            }
            document.getElementById(tabName).style.display = 'block';

            const tabButtons = document.getElementsByClassName('inventory-tab');
            for (let i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove('active');
            }
            event.target.classList.add('active');
        }

        function editItem(type, id) {
            console.log(`Editing ${type} item with ID: ${id}`);
            
        }

        function deleteItem(type, id) {
            console.log(`Deleting ${type} item with ID: ${id}`);
        
        }

    
        renderData();
    </script>
</body>
</html>
