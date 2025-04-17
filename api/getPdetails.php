<?php
// Database connection
include 'db.php';
// Fetch payment data
$sql = "SELECT orderId, amount , viewed FROM payment WHERE viewed = '0' ";  // Adjust your query if necessary
$result = $conn->query($sql);

// Fetch rows and populate the table
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
