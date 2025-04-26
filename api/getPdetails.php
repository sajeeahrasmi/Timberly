<?php

include 'db.php';

$sql = "SELECT orderId, amount , viewed FROM payment WHERE viewed = '0' ";  
$result = $conn->query($sql);

$tableRows = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableRows .= "<tr>
                        <td>" . $row['orderId'] . "</td>
                        <td>Rs: " . $row['amount'] . "</td>
                        <td><button class='mark-read-button' onclick='markAsRead(" . $row['orderId'] . ")'>Mark as Read</button></td>
                    </tr>";

}                } else {
    $tableRows = "<tr><td colspan='3'>No payments found</td></tr>";
}

$conn->close();
?>
