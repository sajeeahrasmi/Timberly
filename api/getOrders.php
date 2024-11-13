<?php
// Include the mockOrders.php to get the orders
include 'mockOrders2.php';  // No need for file_get_contents or json_decode here as the data is already being returned as JSON

// Loop through the orders and display them in the table
foreach ($orders as $order) {
    // Generate the HTML content for each order
    echo "<tr>";
    echo "<td>" . $order['customer_id'] . "</td>";
    echo "<td>" . $order['customer_name'] . "</td>";
    echo "<td>" . $order['order_id'] . "</td>";
    echo "<td>" . $order['order_details'] . "</td>";
    echo "<td>" . $order['status'] . "</td>";
    echo "<td><a href='vieworder.php?id=" . $order['order_id'] . "' class='view-btn'>View Order</a></td>";
    echo "</tr>";
}
?>
