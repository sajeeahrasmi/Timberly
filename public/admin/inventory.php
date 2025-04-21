<?php
// Authentication check MUST be the first thing in the file
// require_once '../../api/auth.php';

// Rest of your existing PHP code follows...
?>
<?php
    include '../../api/InventoryItems.php';
    

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
    <link rel="stylesheet" href="./styles/inventory.css">
    
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
            background-color:rgb(255, 255, 255);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.25);
            margin: 20px auto; /* Reduced margin-top */
            padding: 20px; /* Reduced padding *//* Increased padding for better spacing */
            border: none; /* Brown border around the entire inventory section */
        }

        /* Title styling */
        .content h1 {
            margin-bottom: 30px; /* More spacing for title */
            font-size: 16px; /* Larger font size */
            color: #333;
            text-align: left !important;
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
        }

        .inventory-table th {
            padding-left: 30px;
        }

        .inventory-table th,
        .inventory-table td {
            border-bottom: 1px solid #ddd !important;
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
    <div class="dashboard-container">
        <?php include "./components/sidebar.php" ?>
        <div class="main-content">
            <?php include "./components/header.php" ?>
            <div id="inventory-section" class="content">
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
                    <h3>Timber Inventory</h3>
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Material Type</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Supplier Id</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($timberData as $item): ?>
                                <tr>
                                    <td><?php echo $item['material_type']; ?></td>
                                    <td><?php echo $item['qty']; ?></td>
                                    <td><?php echo $item['price']; ?></td>
                                    <td><?php echo $item['supplierId']; ?></td>
                                    <td class="inventory-actions">
                                        <button class="edit" onclick="handleEdit(this, 'timber')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="delete"  onclick="deleteTimberItem($item['id'])">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="lumber" class="tab-content" style="display:none;">
                    <h3>Lumber Inventory</h3>
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Material Type</th>
                                <th>Logs</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lumberData as $item): ?>
                                <tr>
                                    <td><?php echo $item['material_type']; ?></td>
                                    <td><?php echo $item['unitPrice']; ?></td>
                                    <td><?php echo $item['qty']; ?></td>
                                    
                                    
                                    <td class="inventory-actions">
                                        <button class="edit" onclick="handleEdit(this, 'lumber')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="delete" onclick="deleteLumberItem(<?php echo $item['id']; ?>)">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const timberData = <?php echo json_encode($timberData); ?>;
        const lumberData = <?php echo json_encode($lumberData); ?>;
        let currentFilter = '';
  // Modify the delete function to handle type and id
// Delete Timber Item
// Add these functions to your existing JavaScript code

function makeEditable(cell) {
    const currentValue = cell.textContent;
    cell.innerHTML = `<input type="number" class="edit-input" value="${currentValue}" style="width: 80px;">`;
}

function saveEdit(row, type) {
    const cells = row.cells;
    let id;
    
    try {
        const deleteButton = row.querySelector('.delete');
        const onclickAttr = deleteButton.getAttribute('onclick');
        // Extract ID more reliably
        id = onclickAttr.match(/\d+/)[0];
    } catch (e) {
        console.error('Error getting ID:', e);
        alert('Error: Could not find item ID');
        return;
    }
    
    if (!id) {
        alert('Error: Could not find item ID');
        return;
    }
    
    let data = {
        id: id
    };
    
    if (type === 'timber') {
        const qtyInput = cells[1].querySelector('input');
        data.qty = qtyInput.value;
        cells[1].textContent = qtyInput.value;
    } else if (type === 'lumber') {
        const logsInput = cells[1].querySelector('input');
        data.qty = logsInput.value;
        cells[1].textContent = logsInput.value;
    }
    
    updateInventory(type, data);
}
async function updateInventory(type, data) {
    try {
        
        const formData = new FormData();
        formData.append('id', data.id);
        formData.append('type', type);
        formData.append('quantity', data.qty);
        
        const response = await fetch('../../api/updateTimberInventory.php', {
            method: 'POST',
            body: formData  
        });
        
        const result = await response.json();
        if (result.success) {
            alert('Update successful!');
        } else {
            throw new Error(result.message || 'Update failed');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating inventory: ' + error.message);
    }
}

function handleEdit(button, type) {
    const row = button.closest('tr');
    const isEditing = button.textContent.includes('Save');
    
    if (isEditing) {
        
        saveEdit(row, type);
        button.innerHTML = '<i class="fas fa-edit"></i> Edit';
    } else {
        
        const editableCell = type === 'timber' ? row.cells[1] : row.cells[1]; 
        makeEditable(editableCell);
        button.innerHTML = '<i class="fas fa-save"></i> Save';
    }
}

// Delete Timber Item
async function deleteTimberItem(id) {
    console.log('Attempting to delete lumber item with ID:', id);
    
    if (!confirm('Are you sure you want to delete this Timber item?')) {
        return;
    }

    try {
        const response = await fetch('../../api/deleteTimberInventory.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id: id })
        });

        console.log('Response status:', response.status); // Debug log
        
        const result = await response.text(); // Get raw response text first
        console.log('Raw response:', result); // Debug log
        
        try {
            const jsonResult = JSON.parse(result);
            if (jsonResult.success) {
                const row = document.querySelector(`button[onclick*="deleteTimberItem(${id})"]`).closest('tr');
                if (row) {
                    row.remove();
                    alert('Item deleted successfully!');
                }
            } else {
                throw new Error(jsonResult.message || 'Failed to delete item');
            }
        } catch (parseError) {
            console.error('JSON Parse Error:', parseError);
            throw new Error('Invalid response from server');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error deleting item: ' + error.message);
    }
}


async function deleteLumberItem(id) {
    console.log('Attempting to delete lumber item with ID:', id); // Debug log
    
    if (!confirm('Are you sure you want to delete this Lumber item?')) {
        return;
    }

    try {
        const response = await fetch('../../api/deleteLumberInventory.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id: id })
        });

        console.log('Response status:', response.status); // Debug log
        
        const result = await response.text(); // Get raw response text first
        console.log('Raw response:', result); // Debug log
        
        try {
            const jsonResult = JSON.parse(result);
            if (jsonResult.success) {
                const row = document.querySelector(`button[onclick*="deleteLumberItem(${id})"]`).closest('tr');
                if (row) {
                    row.remove();
                    alert('Item deleted successfully!');
                }
            } else {
                throw new Error(jsonResult.message || 'Failed to delete item');
            }
        } catch (parseError) {
            console.error('JSON Parse Error:', parseError);
            throw new Error('Invalid response from server');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error deleting item: ' + error.message);
    }
}

// Add click handlers to delete buttons

    



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

    // Filtered Timber Data
    const filteredTimber = currentFilter
        ? timberData.filter(item => item.type === currentFilter)
        : timberData;
    filteredTimber.forEach(item => {
        timberTableBody.innerHTML += `
            <tr>
                <td>${item.type}</td>
                <td>${item.qty}</td>
                <td>${item.price}</td>
                <td>${item.supplierId}</td>
                <td class="inventory-actions">
                <button class="edit" onclick="handleEdit(this, 'timber')">
    <i class="fas fa-edit"></i> Edit
</button>
                    <button class="delete" onclick="deleteTimberItem(${item.id})">
    <i class="fas fa-trash-alt"></i> Delete
</button>

                </td>
            </tr>`;
    });

    // Filtered Lumber Data
    const filteredLumber = currentFilter
        ? lumberData.filter(item => item.type === currentFilter)
        : lumberData;
    filteredLumber.forEach(item => {
        lumberTableBody.innerHTML += `
            <tr>
                <td>${item.type}</td>
                <td>${item.qty}</td>
                <td>${item.unitPrice}</td>
                
                <td class="inventory-actions">
                <button class="edit" onclick="handleEdit(this, 'lumber')">
    <i class="fas fa-edit"></i> Edit
</button>
                    <button class="delete" onclick="deleteLumberItem(${item.id})">
    <i class="fas fa-trash-alt"></i> Delete
</button>



</button>

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
        
        
    
        renderData();
    </script>
    
</body>
</html>
