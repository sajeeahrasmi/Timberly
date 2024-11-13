<?php
//Mockdata
$rawMaterialsData = [
    [
        'supplier' => 'Lumber Co.',
        'items' => [
            ['name' => 'Mahogany', 'type' => 'Lumber', 'price' => 15, 'quantity' => 100, 'thickness' => 2, 'length' => 96, 'width' => 48],
            ['name' => 'Oak', 'type' => 'Lumber', 'price' => 10, 'quantity' => 150, 'thickness' => 1.5, 'length' => 120, 'width' => 24],
        ]
    ],
    [
        'supplier' => 'Timber Traders',
        'items' => [
            ['name' => 'Pine', 'type' => 'Timber', 'price' => 8, 'quantity' => 200, 'thickness' => 1, 'length' => 144, 'width' => 12],
            ['name' => 'Cedar', 'type' => 'Timber', 'price' => 12, 'quantity' => 120, 'thickness' => 0.75, 'length' => 96, 'width' => 36],
        ]
    ]
];

// Furniture Data
$furnitureData = [
    ['name' => 'Chair', 'material' => 'Mahogany', 'type' => 'Chair', 'price' => 25],
    ['name' => 'Table', 'material' => 'Oak', 'type' => 'Table', 'price' => 75],
    ['name' => 'Window', 'material' => 'Pine', 'type' => 'Window', 'price' => 40],
    ['name' => 'Door', 'material' => 'Cedar', 'type' => 'Door', 'price' => 90],
];
?>