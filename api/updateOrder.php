<?php
header('Content-Type: application/json');
include 'db.php'; 


$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['orderId']) || !isset($data['newStatus'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$orderId = $data['orderId'];
$newStatus = $data['newStatus'];

if ($newStatus === 'Pending') {
    
    $sqlLumber = "DELETE FROM orderlumber WHERE orderId = ?";
    $sqlFurniture = "DELETE FROM orderfurniture WHERE orderId = ?";
    $sqlcFurniture = "DELETE FROM ordercustomizedfurniture WHERE orderId = ?";

    $stmtLumber = $conn->prepare($sqlLumber);
    $stmtFurniture = $conn->prepare($sqlFurniture);
    $stmtcFurniture = $conn->prepare($sqlcFurniture);
    
    $stmtLumber->bind_param("i", $orderId);
    $stmtFurniture->bind_param("i", $orderId);
    $stmtcFurniture->bind_param("i", $orderId);
    
    $successLumber = $stmtLumber->execute();
    $successFurniture = $stmtFurniture->execute();
    $successcFurniture = $stmtcFurniture->execute();

    if ($successLumber && $successFurniture && $successcFurniture) {
        echo json_encode(["success" => true, "message" => "Orders deleted because status is 'Pending'"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmtLumber->close();
    $stmtFurniture->close();
    $stmtcFurniture->close();
} else {
    
    $sqlLumber = "UPDATE orderlumber SET status = ? WHERE orderId = ?";
    $sqlFurniture = "UPDATE orderfurniture SET status = ? WHERE orderId = ?";
    $sqlcFurniture = "UPDATE ordercustomizedfurniture SET status = ? WHERE orderId = ?";

    $stmtLumber = $conn->prepare($sqlLumber);
    $stmtFurniture = $conn->prepare($sqlFurniture);
    $stmtcFurniture = $conn->prepare($sqlcFurniture);

    $stmtLumber->bind_param("si", $newStatus, $orderId);
    $stmtFurniture->bind_param("si", $newStatus, $orderId);
    $stmtcFurniture->bind_param("si", $newStatus, $orderId);

    $successLumber = $stmtLumber->execute();
    $successFurniture = $stmtFurniture->execute();
    $successcFurniture = $stmtcFurniture->execute();

    if ($successLumber && $successFurniture && $successcFurniture) {
        echo json_encode(["success" => true, "message" => "Order status updated"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmtLumber->close();
    $stmtFurniture->close();
    $stmtcFurniture->close();
}

$conn->close();
?>
