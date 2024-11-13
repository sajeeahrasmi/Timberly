<?php
// Mock data for Timber and Lumber
$timberData = [
    ['id' => 1, 'material_type' => 'Oak', 'logs' => 100, 'bought_date' => '2024-03-15'],
    ['id' => 2, 'material_type' => 'Pine', 'logs' => 150, 'bought_date' => '2024-03-10'],
    ['id' => 3, 'material_type' => 'Maple', 'logs' => 80, 'bought_date' => '2024-03-05'],
];

$lumberData = [
    ['id' => 1, 'material_type' => 'Cedar', 'logs' => 120, 'bought_date' => '2024-03-12'],
    ['id' => 2, 'material_type' => 'Birch', 'logs' => 90, 'bought_date' => '2024-03-08'],
    ['id' => 3, 'material_type' => 'Walnut', 'logs' => 70, 'bought_date' => '2024-03-01'],
];

// Function to get unique material types
function getMaterialTypes($data) {
    return array_unique(array_column($data, 'material_type'));
}

$timberMaterialTypes = getMaterialTypes($timberData);
$lumberMaterialTypes = getMaterialTypes($lumberData);
?>