<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
    $orderId = intval($_POST['orderId']);
    $sql = "UPDATE payment SET viewed = '1' WHERE orderId = $orderId";

    if ($conn->query($sql) === TRUE) {
        echo "Updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>
