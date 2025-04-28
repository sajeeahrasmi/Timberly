<?php

include_once '../db_connection.php';
header('Content-Type: application/json');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'addItem':
            addItem();
            break;

        case 'deleteItem':
            deleteItem();
            break;
        
        case 'updateItem':
            updateItem();
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

function addItem() {
    $host = 'localhost';
    $dbname = 'Timberly';
    $username = 'root';
    $password = ''; 

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die(json_encode(['status' => 'error', 'message' => 'DB Connection failed: ' . $e->getMessage()]));
    }

    $response = ['success' => false];

    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Invalid request method.");
        }

        $orderId = $_POST['orderId'] ?? null;
        $items = json_decode($_POST['item'], true);

        if (!$orderId || !is_array($items) || count($items) === 0) {
            throw new Exception("Invalid order data");
        }

        // Start transaction
        $conn->beginTransaction();

        // Update order itemQty
        $stmt = $conn->prepare("UPDATE orders SET itemQty = itemQty + 1 WHERE orderId = ?");
        $stmt->execute([$orderId]);

        // Get current max itemId
        $stmt2 = $conn->prepare("SELECT itemId FROM ordercustomizedfurniture WHERE orderId = ? ORDER BY itemId DESC LIMIT 1");
        $stmt2->execute([$orderId]);
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);
        $itemId = $result['itemId'] ?? 0;

        foreach ($items as $index => $item) {
            $itemId++; // Increment for each item

            $category = $item['category'];
            $description = $item['description'];
            $type = $item['type'];
            $length = $item['length'];
            $width = $item['width'];
            $thickness = $item['thickness'];
            $quantity = $item['quantity'];
            $additionalDetails = $item['additionalDetails'];
            $imagePath = $item['imagePath'];
            $isCustom = $item['isCustomImage'];

            // If custom image uploaded
            if ($isCustom && isset($_FILES["image_$index"])) {
                $file = $_FILES["image_$index"];
                $targetDir = "../../api/customerUploads/";
                $fileName = time() . "_" . basename($file["name"]);
                $targetFile = $targetDir . $fileName;

                if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                    $imagePath = "../../api/customerUploads/" . $fileName;
                } else {
                    throw new Exception("Failed to upload custom design image.");
                }
            }

            // Insert item
            $stmt = $conn->prepare("INSERT INTO ordercustomizedfurniture 
                (orderId, itemId, category, details, type, length, width, thickness, qty, image, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
            $stmt->execute([
                $orderId, $itemId, $category, $additionalDetails, $type,
                $length, $width, $thickness, $quantity, $imagePath
            ]);
        }

        // Commit transaction if all succeeded
        $conn->commit();
        $response['success'] = true;

    } catch (Exception $e) {
        // Roll back everything on error
        $conn->rollBack();
        $response['error'] = $e->getMessage();
    }

    echo json_encode($response);
}


function deleteItem(){
    global $conn;

    $orderId = $_GET['orderId'];
    $id = $_GET['id'];

    mysqli_begin_transaction($conn);

    try {
        
        $query1 = "UPDATE orders SET itemQty = itemQty - 1 WHERE  orderId = $orderId;";
        $result1 = mysqli_query($conn, $query1);

        if (!$result1) {
            throw new Exception('Failed to update orders table');
        }

        
        // $query2 = "DELETE FROM ordercustomizedfurniture WHERE itemId = $id AND orderId = $orderId";
        // $result2 = mysqli_query($conn, $query2);
        $query2 = "DELETE FROM ordercustomizedfurniture WHERE itemId = ? AND orderId = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("ii", $id, $orderId);
        if (!$stmt2->execute() || $stmt2->affected_rows === 0) {
            throw new Exception('Failed to delete item.');
        }

        // if (!$result2) {
        //     throw new Exception('Failed to delete item.');
        // }

        $sumQuery = "SELECT SUM(qty * unitPrice) AS newTotal FROM ordercustomizedfurniture WHERE orderId = ? AND status != 'Not_Approved'";
        $sumStmt = $conn->prepare($sumQuery);
        $sumStmt->bind_param("i", $orderId);
        $sumStmt->execute();
        $sumResult = $sumStmt->get_result();
        $row = $sumResult->fetch_assoc();
        $newTotal = $row['newTotal'];

        if ($newTotal === null) {
            throw new Exception("Could not calculate new total");
        }

        $updateOrderQuery = "UPDATE orders SET totalAmount = ? WHERE orderId = ?";
        $updateStmt = $conn->prepare($updateOrderQuery);
        $updateStmt->bind_param("di", $newTotal, $orderId);

        if (!$updateStmt->execute()) {
            throw new Exception("Failed to update total amount");
        }
        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['error' => "Couldn't delete item."]);
    }

}

function updateItem(){
    global $conn;

    $id = $_GET['itemId'];
    $orderId = $_GET['orderId'];
    $type = $_GET['type'];
    $length = $_GET['length'];
    $width = $_GET['width'];
    $thickness = $_GET['thickness'];
    $qty = $_GET['qty'];
    $details = $_GET['details'];

    mysqli_begin_transaction($conn);

    try {
        
        $query = "UPDATE ordercustomizedfurniture SET type = ?, length = ?, width = ?, thickness = ?, qty = ?, details = ? WHERE  itemId = ? AND orderId = ?;";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("sdddisii", $type, $length, $width, $thickness, $qty, $details, $id, $orderId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to update into order customized furniture table');
        }

        // $sumQuery = "SELECT SUM(qty * unitPrice) AS newTotal FROM ordercustomizedfurniture WHERE orderId = ? AND status != 'Not_Approved'";
        // $sumStmt = $conn->prepare($sumQuery);
        // $sumStmt->bind_param("i", $orderId);
        // $sumStmt->execute();
        // $sumResult = $sumStmt->get_result();
        // $row = $sumResult->fetch_assoc();
        // $newTotal = $row['newTotal'];

        // if ($newTotal === null) {
        //     throw new Exception("Could not calculate new total");
        // }

        // $updateOrderQuery = "UPDATE orders SET totalAmount = ? WHERE orderId = ?";
        // $updateStmt = $conn->prepare($updateOrderQuery);
        // $updateStmt->bind_param("di", $newTotal, $orderId);

        // if (!$updateStmt->execute()) {
        //     throw new Exception("Failed to update total amount");
        // }
        

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        
    }
}

function updateReview() {
    global $conn;

    $orderId = $_GET['orderId'];
    $Id = $_GET['Id'];
    $text = $_GET['reviewText'];

    if (!$orderId || !$Id || !$text) {
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

        $query2 = "UPDATE ordercustomizedfurniture SET reviewId = ? WHERE itemId = ? AND orderId = ?";
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, "iii", $reviewId, $Id, $orderId);
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