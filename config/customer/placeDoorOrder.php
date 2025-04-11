<?php
header('Content-Type: application/json');

try {
    include '../db_connection.php'; // Adjust path if needed

    $userId = $_POST['userId'];
    $itemQty = $_POST['itemQty'];
    $items = json_decode($_POST['items'], true);

    if (!$userId || !$items) {
        throw new Exception("Missing required data");
    }

    $conn->begin_transaction();

    $orderStmt = $conn->prepare("
        INSERT INTO orders (userId, itemQty, date, status, category) 
        VALUES (?, ?, NOW(), 'Pending', 'CustomisedFurniture')
    ");
    $orderStmt->bind_param("ii", $userId, $itemQty);
    $orderStmt->execute();

    if ($orderStmt->error) {
        throw new Exception("Error creating order: " . $orderStmt->error);
    }

    $orderId = $conn->insert_id;

    $itemStmt = $conn->prepare("
        INSERT INTO ordercustomizedfurniture (orderId, itemId, type, length, width, thickness, qty, details, image, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
    ");

    $itemCounter = 1;

    foreach ($items as $index => $item) {
        $type = $item['type'];
        $length = $item['length'];
        $width = $item['width'];
        $thickness = $item['thickness'];
        $qty = $item['quantity'];
        $additionalDetails = $item['additionalDetails'];
        $itemId = $itemCounter++;
        $imagePath = "";

        if ($item['isCustomImage']) {
            $imageIndex = $item['imageIndex'];
            $uploadKey = "image_" . $imageIndex;

            if (isset($_FILES[$uploadKey]) && $_FILES[$uploadKey]['error'] == 0) {
                $file = $_FILES[$uploadKey];
                $fileName = time() . '_' . $userId . '_' . basename($file['name']);
                $uploadDir = "../../api/customerUploads/";
                $uploadPath = $uploadDir . $fileName;

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $imagePath = $uploadPath;
                } else {
                    throw new Exception("Failed to upload custom image.");
                }
            } else {
                throw new Exception("Missing uploaded custom image: $uploadKey");
            }

        } else {
            $imageSrc = $item['imagePath'];

            // Case 1: Full URL, extract relative
            if (strpos($imageSrc, 'http://localhost/Timberly/public/images/') !== false) {
                $fileName = basename($imageSrc);
                $imagePath = "../images/" . $fileName;

            // Case 2: Already relative path
            } elseif (strpos($imageSrc, '../images/') !== false) {
                $imagePath = $imageSrc;

            // Unexpected format
            } else {
                throw new Exception("Invalid image path format: " . $imageSrc);
            }
        }

        // Validate final path
        if (!$imagePath || strlen(trim($imagePath)) === 0) {
            throw new Exception("Image path is empty or null before insert.");
        }

        // Log what’s being inserted
        error_log("✔ Inserting item #$index with image path: $imagePath");

        $itemStmt->bind_param("iisdddiss", $orderId, $itemId, $type, $length, $width, $thickness, $qty, $additionalDetails, $imagePath);
        $itemStmt->execute();

        if ($itemStmt->error) {
            throw new Exception("Error inserting item: " . $itemStmt->error);
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    if (isset($conn) && !$conn->connect_error) {
        $conn->rollback();
    }
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
