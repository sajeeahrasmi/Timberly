<?php 
// Include the PHP file with the orders and details
include 'mockOrders2.php'; 

// Iterate over the orders and display the data in table rows
foreach ($orders as &$order) {
    echo "<tr>";
    echo "<td>" . $order['customer_id'] . "</td>";
    echo "<td>" . $order['customer_name'] . "</td>";
    echo "<td>" . $order['order_id'] . "</td>";

    // Display order details (products, quantity, and price)
    echo "<td>";
    $total_amount = 0;  // Initialize total amount for each order
    foreach ($order['order_details'] as $detail) {
        // Display the details of each product in the order
        echo $detail['quantity'] . "x Product ID " . $detail['product_id'] . " ($" . $detail['price'] . " each)<br>";
        
        // Calculate the total amount for the order
        $total_amount += $detail['quantity'] * $detail['price'];
    }
    echo "</td>";
// Before displaying the orders, check the content of $orders

    // Display total amount (calculated), total payment, and balance
    echo "<td>$" . number_format($total_amount, 2) . "</td>";  // Display total amount
    echo "<td>$" . number_format($order['total_payment'], 2) . "</td>";  // Display total payment
    echo "<td>$" . number_format($order['balance'], 2) . "</td>";  // Display balance

    // Display order status
    echo "<td>" . $order['status'] . "</td>";

    // Link to view the order details
    echo "<td><a href='vieworder.php?id=" . $order['order_id'] . "' class='view-btn'>View Order</a></td>";
    echo "</tr>";
}
?>
