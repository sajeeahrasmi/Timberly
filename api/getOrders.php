<?php
include 'mockOrders2.php';

// Get filter values
$customer_filter = isset($_GET['customer_filter']) ? strtolower($_GET['customer_filter']) : '';
$order_filter = isset($_GET['order_filter']) ? strtolower($_GET['order_filter']) : '';

foreach ($orders as &$order) {
    // Apply filters
    if ($customer_filter && 
        !str_contains(strtolower($order['customer_id']), $customer_filter) && 
        !str_contains(strtolower($order['customer_name']), $customer_filter)) {
        continue;
    }
    
    if ($order_filter && 
        !str_contains(strtolower($order['order_id']), $order_filter)) {
        continue;
    }

    echo "<tr>";
    echo "<td>" . $order['customer_id'] . "</td>";
    echo "<td>" . $order['customer_name'] . "</td>";
    echo "<td>" . $order['order_id'] . "</td>";
    
    echo "<td>";
    $total_amount = 0;
    foreach ($order['order_details'] as $detail) {
        echo $detail['quantity'] . "x Product ID " . $detail['product_id'] . " (Rs." . $detail['price'] . " each)<br>";
        $total_amount += $detail['quantity'] * $detail['price'];
    }
    echo "</td>";

    echo "<td>Rs." . number_format($total_amount, 2) . "</td>";
    echo "<td>Rs." . number_format($order['total_payment'], 2) . "</td>";
    echo "<td>Rs." . number_format($order['balance'], 2) . "</td>";
    echo "<td>" . $order['status'] . "</td>";
    echo "<td><a href='vieworder.php?id=" . $order['order_id'] . "' class='view-btn'>View Order</a></td>";
    echo "</tr>";
}
?>