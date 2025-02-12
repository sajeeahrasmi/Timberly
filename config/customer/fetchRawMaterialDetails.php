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
        
        case 'updateQty':
            updateQty();
            break;

        case 'fetchDriverDetail':
            fetchDriverDetail();
            break;

        case 'updateReview':
            updateReview();
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

        $query2 = "SELECT qty, status, driverId, date FROM orderLumber WHERE orderId = $orderId AND itemId = $itemId";
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

function updateQty(){
    global $conn;

    $orderId = $_GET['orderId'];
    $itemId = $_GET['itemId'];
    $qty = $_GET['qty'];

    if (!$orderId || !$itemId || !$qty) {
        echo json_encode(["success" => false, "message" => "Invalid parameters"]);
        return;
    }

    mysqli_begin_transaction($conn);

    try{
        $query = " UPDATE orderLumber SET qty = $qty WHERE orderId = $orderId AND itemId = $itemId";
        $result = mysqli_query($conn, $query);

        if(!$result){
            throw new Exception("Failed to update quantity");
        }

        mysqli_commit($conn);

        echo json_encode([ "success" => true]);

    }catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    mysqli_close($conn);
}

function fetchDriverDetail(){
    global $conn;

    $driverId = $_GET['driverId'];

    if (!$driverId) {
        echo json_encode(["success" => false, "message" => "Invalid parameters"]);
        return;
    }

    mysqli_begin_transaction($conn);

    try{
        $query1 = "SELECT vehicleNo FROM driver WHERE driverId = $driverId";
        $result1 = mysqli_query($conn, $query1);
        $vehicle = mysqli_fetch_assoc($result1);

        $query2 = "SELECT name, phone FROM user WHERE userId = $driverId";
        $result2 = mysqli_query($conn, $query2);
        $personalDetails = mysqli_fetch_assoc($result2);

        if (!$vehicle || !$personalDetails) {
            throw new Exception("Failed to fetch one or more records.");
        }

        mysqli_commit($conn);

        echo json_encode([
            "success" => true,
            "vehicle" => $vehicle['vehicleNo'],
            "personalDetail" => $personalDetails
        ]);

    }catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    mysqli_close($conn);
}


function updateReview() {
    global $conn;

    $orderId = $_GET['orderId'];
    $itemId = $_GET['itemId'];
    $text = $_GET['reviewText'];

    if (!$orderId || !$itemId || !$text) {
        echo json_encode(["success" => false, "message" => "Invalid parameters"]);
        return;
    }

    mysqli_begin_transaction($conn);

    try {
        $query = "INSERT INTO review (review) VALUES (?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $text);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            throw new Exception("Failed to insert review");
        }

        $query1 = "SELECT reviewId FROM review WHERE review = ?";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $text);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $reviewData = mysqli_fetch_assoc($result1);
        $reviewId = $reviewData['reviewId'];

        if (!$reviewId) {
            throw new Exception("Failed to retrieve review ID");
        }

        $query2 = "UPDATE orderLumber SET reviewId = ? WHERE orderId = ? AND itemId = ?";
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, "iii", $reviewId, $orderId, $itemId);
        $result2 = mysqli_stmt_execute($stmt2);

        if (!$result2) {
            throw new Exception("Failed to update orderLumber with review ID");
        }

        mysqli_commit($conn);
        echo json_encode(["success" => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    mysqli_close($conn);
}

?>
