<?php

$timberData = [
    ['id' => 1, 'material_type' => 'Sooriyamaara', 'logs' => 100, 'bought_date' => '2024-03-15'],
    ['id' => 2, 'material_type' => 'Jak', 'logs' => 150, 'bought_date' => '2024-03-10'],
    ['id' => 3, 'material_type' => 'Nedum', 'logs' => 80, 'bought_date' => '2024-03-05'],
];

$lumberData = [
    ['id' => 1, 'material_type' => 'Mahogany', 'logs' => 120, 'bought_date' => '2024-03-12'],
    ['id' => 2, 'material_type' => 'Teak', 'logs' => 90, 'bought_date' => '2024-03-08'],
    
];


function getMaterialTypes($data) {
    return array_unique(array_column($data, 'material_type'));
}

$timberMaterialTypes = getMaterialTypes($timberData);
$lumberMaterialTypes = getMaterialTypes($lumberData);
?>