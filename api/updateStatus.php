<?php
// Include the database connection
require_once 'db.php';

// Get the POST data
$orderId = isset($_POST['orderId']) ? $_POST['orderId'] : '';
$itemId = isset($_POST['itemId']) ? $_POST['itemId'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$orderType = isset($_POST['orderType']) ? $_POST['orderType'] : '';

// Update the order status in the database
if ($status== 'Confirmed'){
    $sql = "UPDATE orders 
        SET status = ? 
        WHERE orderId = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $orderId);
}

else if ($orderType == 'lumber'){
    $sql = "UPDATE orderlumber
    SET status = ?
    WHERE orderId = ? AND itemId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $orderId, $itemId);
}
else if ($orderType == 'furniture'){
    $sql = "UPDATE orderfurniture
    SET status = ?
    WHERE orderId = ? AND itemId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $orderId, $itemId);
}


if ($stmt->execute()) {
    // Respond back with success
    echo json_encode(["status" => "success", "message" => "Order status updated successfully"]);
} else {
    // Respond back with an error
    echo json_encode(["status" => "error", "message" => "Failed to update order status"]);
}

$stmt->close();
$conn->close();
?>
