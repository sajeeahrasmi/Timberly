<?php
require '../../config/db_connection.php'; 
header("Content-Type: application/json");

$orderId;
$itemId;
$userId;

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

    $orderId = $_GET['orderId'];
    $itemId = $_GET['itemId'];
    $userId = $_GET['userId'];

    if (!$orderId || !$itemId || !$userId) {
        echo json_encode(["success" => false, "message" => "Invalid parameters"]);
        return;
    }

    mysqli_begin_transaction($conn);

    try{
        $query1 = "SELECT status FROM orders WHERE orderId = $orderId";
        $result1 = mysqli_query($conn, $query1);
        $orderStatus = mysqli_fetch_assoc($result1);

        $query2 = "SELECT qty, status FROM orderLumber WHERE orderId = $orderId AND itemId = $itemId";
        $result2 = mysqli_query($conn, $query2);
        $lumberDetail = mysqli_fetch_assoc($result2);

        $query3 = "SELECT type, length, width, thickness, unitPrice FROM lumber WHERE lumberId = $itemId";
        $result3 = mysqli_query($conn, $query3);
        $details = mysqli_fetch_assoc($result3);

        if (!$orderStatus || !$lumberDetail || !$details) {
            throw new Exception("Failed to fetch one or more records.");
        }

        mysqli_commit($conn);

        echo json_encode([
            "success" => true,
            "orderStatus" => $orderStatus['status'],
            "itemDetail" => $lumberDetail,
            "lumber" => $details
        ]);

    }catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    mysqli_close($conn);
}


?>
