<?php 

include 'mockOrders2.php'; 


foreach ($orders as &$order) {
    echo "<tr>";
    echo "<td>" . $order['customer_id'] . "</td>";
    echo "<td>" . $order['customer_name'] . "</td>";
    echo "<td>" . $order['order_id'] . "</td>";

    
    echo "<td>";
    $total_amount = 0;  
    foreach ($order['order_details'] as $detail) {
      
        echo $detail['quantity'] . "x Product ID " . $detail['product_id'] . " ($" . $detail['price'] . " each)<br>";
        
        
        $total_amount += $detail['quantity'] * $detail['price'];
    }
    echo "</td>";


    
    echo "<td>$" . number_format($total_amount, 2) . "</td>";  
    echo "<td>$" . number_format($order['total_payment'], 2) . "</td>";  
    echo "<td>$" . number_format($order['balance'], 2) . "</td>";  

    
    echo "<td>" . $order['status'] . "</td>";

    
    echo "<td><a href='vieworder.php?id=" . $order['order_id'] . "' class='view-btn'>View Order</a></td>";
    echo "</tr>";
}
?>
