<?php
include 'db.php';
header('Content-Type: application/json');


// Query to check for payments with value 0
$sql = "SELECT COUNT(*) AS unpaidPayments FROM payment WHERE viewed = '0'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch result
    $row = $result->fetch_assoc();
    echo json_encode(array("unpaidPayments" => $row["unpaidPayments"]));
} else {
    echo json_encode(array("unpaidPayments" => 0));
}

$conn->close();
?>
