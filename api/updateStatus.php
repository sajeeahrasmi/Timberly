<?php
// Include the database connection
require_once 'db.php';

// Get the POST data
$orderId = isset($_POST['orderId']) ? $_POST['orderId'] : '';
$itemId = isset($_POST['itemId']) ? $_POST['itemId'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$orderType = isset($_POST['orderType']) ? $_POST['orderType'] : '';
//if status in not_deiverd chang ot to finished or ele keep same
if($status == 'Not_Delivered' ){
    $status = 'Finished';
}
else if($status == 'Completed')
{
    $status = 'Delivered';
}
else
{
    $status = $status;
}
// Update the order status in the database
if ($status== 'Confirmed'){
    $sql = "UPDATE orders 
        SET status = ? 
        WHERE orderId = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $orderId);
}

else if (($orderType == 'lumber' || $orderType == 'furniture' || $orderType == 'customized') && $status == 'Processing') {
    
    // Step 1: Update orders table
    $sql = "UPDATE orders 
            SET status = ? 
            WHERE orderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $orderId);
    $stmt->execute();
    
    // Step 2: Update corresponding product table
    if (!empty($itemId)) {
        $tableName = ''; // sanitize and validate this
        if ($orderType == 'lumber') {
            $tableName = 'orderlumber';
        } elseif ($orderType == 'furniture') {
            $tableName = 'orderfurniture';
        } elseif ($orderType == 'customized') {
            $tableName = 'ordercustomizedfurniture';
        }

        // Only update if tableName was matched
        if (!empty($tableName)) {
            $sql = "UPDATE $tableName 
                    SET status = ? 
                    WHERE itemId = ? AND orderId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $status, $itemId , $orderId);
            $stmt->execute();
            
        }
    }
}

else if ($orderType == 'lumber' ){
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

else{
    $sql = "UPDATE ordercustomizedfurniture
    SET status = ?
    WHERE orderId = ? AND itemId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $orderId, $itemId);
}


if ($stmt->execute()) {
    // Respond back with success
    echo json_encode(["status" => "success", "message" => "Order status updated successfully"]);

    // Check if all items in the order are "Delivered"
    $sql = "SELECT status FROM orderlumber WHERE orderId = ?"; // Adjust table based on order type
    if ($orderType == 'furniture') {
        $sql = "SELECT status FROM orderfurniture WHERE orderId = ?";
    } elseif ($orderType == 'customized') {
        $sql = "SELECT status FROM ordercustomizedfurniture WHERE orderId = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if all items are "Delivered"
    $allDelivered = true;
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] !== 'Delivered') {
            $allDelivered = false;
            break;
        }
    }

    // If all items are delivered, update order status to "Completed"
    if ($allDelivered) {
        $updateOrderStatus = "UPDATE orders SET status = 'Completed' WHERE orderId = ?";
        $stmt = $conn->prepare($updateOrderStatus);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
    }

} else {
    // Respond back with an error
    echo json_encode(["status" => "error", "message" => "Failed to update order status"]);
}

$stmt->close();
$conn->close();
?>