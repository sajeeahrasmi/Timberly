<?php
$orders = [
    [
        'customer_id' => 101,
        'customer_name' => 'John Doe',
        'order_id' => 5001,
        'order_details' => '5x Chair, 1x Table',
        'status' => 'Pending'
    ],
    [
        'customer_id' => 102,
        'customer_name' => 'Jane Smith',
        'order_id' => 5002,
        'order_details' => '1x Sofa',
        'status' => 'Pending'
    ],
    [
        'customer_id' => 103,
        'customer_name' => 'Alice Johnson',
        'order_id' => 5003,
        'order_details' => '3x Bed',
        'status' => 'Processing'
    ]
];

// Instead of returning an array, we use json_encode to output a JSON string
echo json_encode($orders);?>
