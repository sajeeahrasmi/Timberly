<?php
// Mock data for orders
$orders = [
    [
        'order_id' => 5001,
        'customer_id' => 101,
        'customer_name' => 'Amal perera',
        'date' => '2024-11-01',
        'total_payment' => 150.00,
        'total' => 1000.00,
        'balance' => 850.00,
        'status' => 'Pending',
        'order_details' => []  // Placeholder for order details
    ],
    [
        'order_id' => 5002,
        'customer_id' => 102,
        'customer_name' => 'Jayasundara Sunimal',
        'date' => '2024-11-02',
        'total_payment' => 150.00,
        'total' => 1000.00,
        'balance' => 850.00,
        'status' => 'Pending',
        'order_details' => []  // Placeholder for order details
    ],
    [
        'order_id' => 5003,
        'customer_id' => 103,
        'customer_name' => 'Alice Johnson',
        'date' => '2024-11-03',
        'total_payment' => 150.00,
        'total' => 1000.00,
        'balance' => 850.00,
        'status' => 'Processing',
        'order_details' => []  // Placeholder for order details
    ],
    [
        'order_id' => 5004,
        'customer_id' => 104,
        'customer_name' => 'Bob Brown',
        'date' => '2024-11-04',
        'total_payment' => 200.00,
        'total' => 1500.00,
        'balance' => 1300.00,
        'status' => 'Shipped',
        'order_details' => []  // Placeholder for order details
    ],
    [
        'order_id' => 5005,
        'customer_id' => 105,
        'customer_name' => 'Charlie Davis',
        'date' => '2024-11-05',
        'total_payment' => 250.00,
        'total' => 1800.00,
        'balance' => 1550.00,
        'status' => 'Delivered',
        'order_details' => []  // Placeholder for order details
    ],
    [
        'order_id' => 5006,
        'customer_id' => 106,
        'customer_name' => 'Evanthara Nimnavi',
        'date' => '2024-11-06',
        'total_payment' => 100.00,
        'total' => 700.00,
        'balance' => 600.00,
        'status' => 'Pending',
        'order_details' => []  // Placeholder for order details
    ],
    [
        'order_id' => 5007,
        'customer_id' => 107,
        'customer_name' => 'David Green',
        'date' => '2024-11-07',
        'total_payment' => 300.00,
        'total' => 2000.00,
        'balance' => 1700.00,
        'status' => 'Shipped',
        'order_details' => []  // Placeholder for order details
    ],
    [
        'order_id' => 5008,
        'customer_id' => 108,
        'customer_name' => 'Grace Blue',
        'date' => '2024-11-08',
        'total_payment' => 500.00,
        'total' => 3500.00,
        'balance' => 3000.00,
        'status' => 'Processing',
        'order_details' => []  // Placeholder for order details
    ]
];

// Mock data for order details
$order_details = [
    [
        'order_id' => 5001,
        'order_detail_id' => 1,
        'product_id' => 201,
        'quantity' => 5,
        'price' => 25.00
    ],
    [
        'order_id' => 5002,
        'order_detail_id' => 2,
        'product_id' => 202,
        'quantity' => 3,
        'price' => 100.00
    ],
    [
        'order_id' => 5003,
        'order_detail_id' => 3,
        'product_id' => 203,
        'quantity' => 6,
        'price' => 75.00
    ],
    [
        'order_id' => 5001,
        'order_detail_id' => 4,
        'product_id' => 203,
        'quantity' => 2,
        'price' => 25.00
    ],
    [
        'order_id' => 5004,
        'order_detail_id' => 5,
        'product_id' => 204,
        'quantity' => 1,
        'price' => 500.00
    ],
    [
        'order_id' => 5004,
        'order_detail_id' => 6,
        'product_id' => 205,
        'quantity' => 2,
        'price' => 200.00
    ],
    [
        'order_id' => 5005,
        'order_detail_id' => 7,
        'product_id' => 206,
        'quantity' => 3,
        'price' => 150.00
    ],
    [
        'order_id' => 5005,
        'order_detail_id' => 8,
        'product_id' => 207,
        'quantity' => 4,
        'price' => 250.00
    ],
    [
        'order_id' => 5005,
        'order_detail_id' => 9,
        'product_id' => 208,
        'quantity' => 2,
        'price' => 500.00
    ],
    [
        'order_id' => 5006,
        'order_detail_id' => 10,
        'product_id' => 209,
        'quantity' => 4,
        'price' => 100.00
    ],
    [
        'order_id' => 5007,
        'order_detail_id' => 11,
        'product_id' => 210,
        'quantity' => 5,
        'price' => 120.00
    ],
    [
        'order_id' => 5008,
        'order_detail_id' => 12,
        'product_id' => 211,
        'quantity' => 7,
        'price' => 350.00
    ],
    [
        'order_id' => 5009,
        'order_detail_id' => 13,
        'product_id' => 212,
        'quantity' => 6,
        'price' => 300.00
    ]
];

// Add order details to corresponding orders
foreach ($orders as &$order) {
    $order_id = $order['order_id'];
    foreach ($order_details as $detail) {
        if ($detail['order_id'] == $order_id) {
            $order['order_details'][] = $detail;  // Add the respective order details
        }
    }
}

// Output as JSON
echo json_encode($orders);
?>
