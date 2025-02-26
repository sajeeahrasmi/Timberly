<?php
header('Content-Type: application/json');
include 'db.php'; // Ensure this correctly connects to your database

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['orderId']) || !isset($data['newStatus'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$orderId = $data['orderId'];
$newStatus = $data['newStatus'];

if ($newStatus === 'Pending') {
    // Delete from both orderlumber and orderfurniture
    $sqlLumber = "DELETE FROM orderlumber WHERE orderId = ?";
    $sqlFurniture = "DELETE FROM orderfurniture WHERE orderId = ?";

    $stmtLumber = $conn->prepare($sqlLumber);
    $stmtFurniture = $conn->prepare($sqlFurniture);

    $stmtLumber->bind_param("i", $orderId);
    $stmtFurniture->bind_param("i", $orderId);

    $successLumber = $stmtLumber->execute();
    $successFurniture = $stmtFurniture->execute();

    if ($successLumber && $successFurniture) {
        echo json_encode(["success" => true, "message" => "Orders deleted because status is 'Pending'"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmtLumber->close();
    $stmtFurniture->close();
} else {
    // Update status in both orderlumber and orderfurniture
    $sqlLumber = "UPDATE orderlumber SET status = ? WHERE orderId = ?";
    $sqlFurniture = "UPDATE orderfurniture SET status = ? WHERE orderId = ?";

    $stmtLumber = $conn->prepare($sqlLumber);
    $stmtFurniture = $conn->prepare($sqlFurniture);

    $stmtLumber->bind_param("si", $newStatus, $orderId);
    $stmtFurniture->bind_param("si", $newStatus, $orderId);

    $successLumber = $stmtLumber->execute();
    $successFurniture = $stmtFurniture->execute();

    if ($successLumber && $successFurniture) {
        echo json_encode(["success" => true, "message" => "Order status updated"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmtLumber->close();
    $stmtFurniture->close();
}

$conn->close();
?>
