<?php
    include '../../api/inventoryItems.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
</head>
<body>
    <style>
        /* Unique styling for the inventory section */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        #inventory-section {
            width: 100%;
            background-color: #e9ecef;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        h1 {
            margin-bottom: 20px;
        }
        h2 {
            margin-left: 20px;
        }
        #inventory-section h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        /* Filter styles */
        .inventory-filter {
            margin-bottom: 20px;
        }
        .inventory-filter label {
            margin-right: 10px;
            margin-left: 20px;
        }
        /* Tab styles */
        .inventory-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .inventory-tab {
            padding: 10px 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        .inventory-tab.active {
            background-color: #895D47;
            color: white;
        }
        /* Inventory table styles */
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 20px;
            margin-right: 10px;
        }
        .inventory-table th,
        .inventory-table td {
            border: 1px solid #ddd;
            padding: 8px;
            margin-right: 10px;
            
        }
        .inventory-table th {
            background-color: #895D47;;
            text-align: left;
            color : #ffff;
        }
        /* Action button styles */
        .inventory-actions {
            display: flex;
            gap: 10px;
        }
        .inventory-actions button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }
        .inventory-actions .edit {
            background-color:  #218838;
            color: white;
        }
        .inventory-actions .delete {
            background-color: #ca1417;
            color: white;
        }
        .inventory-actions .edit:hover,
        .inventory-actions .delete:hover {
            background-color: #895D47;
        }
    </style>

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
                            <td><?php echo $item['logs']; ?></td>
                            <td><?php echo $item['bought_date']; ?></td>
                            <td class="inventory-actions">
                                <button class="edit" onclick="editItem('timber', <?php echo $item['id']; ?>)">Edit</button>
                                <button class="delete" onclick="deleteItem('timber', <?php echo $item['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="lumber" class="tab-content" style="display: none;">
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
                            <td><?php echo $item['logs']; ?></td>
                            <td><?php echo $item['bought_date']; ?></td>
                            <td class="inventory-actions">
                                <button class="edit" onclick="editItem('lumber', <?php echo $item['id']; ?>)">Edit</button>
                                <button class="delete" onclick="deleteItem('lumber', <?php echo $item['id']; ?>)">Delete</button>
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
            // Clear previous data
            const timberTableBody = document.querySelector('#timber tbody');
            const lumberTableBody = document.querySelector('#lumber tbody');
            timberTableBody.innerHTML = '';
            lumberTableBody.innerHTML = '';

            // Render Timber Data
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

            // Render Lumber Data
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

            // Render data when switching tabs
            renderData();
        }

        function editItem(type, id) {
            // Implement edit functionality
            alert(`Edit ${type} item with ID ${id}`);
        }

        function deleteItem(type, id) {
            // Implement delete functionality
            alert(`Delete ${type} item with ID ${id}`);
        }

        // Initial render
        renderData();
    </script>
</body>
</html>
