<?php
include 'db.php';
header('Content-Type: application/json');



$sql = "SELECT COUNT(*) AS unpaidPayments FROM payment WHERE viewed = '0'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    $row = $result->fetch_assoc();
    echo json_encode(array("unpaidPayments" => $row["unpaidPayments"]));
} else {
    echo json_encode(array("unpaidPayments" => 0));
}

$conn->close();
?>
