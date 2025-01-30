<?php
require '../../config/db_connection.php'; 

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'fetchDetails':
            fetchDetails();
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}

function fetchDetails() {
    global $conn;

    $orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;
    $itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : null;
    $userId = isset($_GET['userId']) ? intval($_GET['userId']) : null;

    if (!$orderId || !$itemId || !$userId) {
        echo json_encode(["success" => false, "message" => "Invalid parameters"]);
        exit;
    }

    $query = "SELECT * FROM orderLumber WHERE orderId = ? AND itemId = ? AND userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $orderId, $itemId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    if ($order) {
        echo json_encode(["success" => true, "orderId" => $order["orderId"], "itemId" => $order["itemId"], "description" => $order["description"], "woodType" => $order["type"], "dimensions" => $order["dimensions"], "quantity" => $order["qty"], "price" => $order["unitPrice"], "status" => $order["status"]]);
    } else {
        echo json_encode(["success" => false, "message" => "Order not found"]);
    }
    
}


?>
