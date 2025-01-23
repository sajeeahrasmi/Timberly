<?php
// Mock data for Timber and Lumber
$timberData = [

    ['id' => 1, 'material_type' => 'Teak', 'logs' => 100, 'bought_date' => '2024-03-15'],
    ['id' => 2, 'material_type' => 'Sooriyam', 'logs' => 150, 'bought_date' => '2024-03-10'],
    ['id' => 3, 'material_type' => 'Mahogany', 'logs' => 80, 'bought_date' => '2024-03-05'],
];

$lumberData = [
    ['id' => 1, 'material_type' => 'Nedum', 'logs' => 120, 'bought_date' => '2024-03-12'],
    ['id' => 2, 'material_type' => 'Jak', 'logs' => 90, 'bought_date' => '2024-03-08'],
    ['id' => 3, 'material_type' => 'Jak', 'logs' => 70, 'bought_date' => '2024-03-01'],

];

// Function to get unique material types
function getMaterialTypes($data) {
    return array_unique(array_column($data, 'material_type'));
}

$timberMaterialTypes = getMaterialTypes($timberData);
$lumberMaterialTypes = getMaterialTypes($lumberData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="./styles/inventory.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="page-content">
                <?php include "./components/header.php" ?>
                <div class="main-content">
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

                                            <a href="#" class="edit" onclick="editItem('timber', <?php echo $item['id']; ?>)"><i class="fas fa-pen-to-square" style="color: #000000;"></i></a>
                                            <a href="#" class="delete" onclick="deleteItem('timber', <?php echo $item['id']; ?>)"><i class="fa-solid fa-trash-can" style="color: #000000;"></i></a>

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
                                    <th>Received Date</th>
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
                                            <a href="#" class="edit" onclick="editItem('lumber', <?php echo $item['id']; ?>)"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i></a>
                                            <a href="#" class="delete" onclick="deleteItem('lumber', <?php echo $item['id']; ?>)"><i class="fa-solid fa-trash-can" style="color: #000000;"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- donot try to remove these script to a js file, as it holds json_encode data -->
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
                                <button class="edit" onclick="editItem('timber', ${item.id})"><i class="fas fa-pen-to-square" style="color: #000000;"></i></button>
                                <button class="delete" onclick="deleteItem('timber', ${item.id})"><i class="fa-solid fa-trash-can" style="color: #000000;"></i></button>
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
                                <button class="edit" onclick="editItem('lumber', ${item.id})"><i class="fas fa-pen-to-square" style="color: #000000;"></i></button>
                                <button class="delete" onclick="deleteItem('lumber', ${item.id})"><i class="fa-solid fa-trash-can" style="color: #000000;"></i></button>
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
