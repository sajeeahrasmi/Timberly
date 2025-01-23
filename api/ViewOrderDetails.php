<?php
// $orderId = $_GET['id'];


$order = [
    'id' => '12345',
    'date' => '2023-09-14',
    'status' => 'Pending',
    'total' => 129.99
];

$customer = [
    'name' => 'Sajeeah',
    'email' => 'sajeeah@gmail.com',
    'phone' => '07712345677',
    'address' => '123 Main St, Sajeeahs town, Kalutara'
];

$orderItems = [
    [
        'name' => 'Product 1',
        'quantity' => 2,
        'price' => 49.99,
        'status' => 'Pending',
        'image' => 'https://via.placeholder.com/100x100.png?text=Product+1'
    ],
    [
        'name' => 'Product 2',
        'quantity' => 1,
        'price' => 30.01,
        'status' => 'Pending',
        'image' => 'https://via.placeholder.com/100x100.png?text=Product+2'
    ]
];

$subtotal = 0;
foreach ($orderItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$deliveryFee = 10.00; // Mock delivery fee
$total = $subtotal + $deliveryFee;
?>