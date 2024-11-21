<?php
header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=localhost;dbname=Timberly", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the itemId from the query parameter
    $itemId = $_GET['itemId'] ?? null;

    if (!$itemId) {
        echo json_encode(['success' => false, 'message' => 'Item ID is required.']);
        exit;
    }

    // Fetch the maximum quantity for the given itemId
    $stmt = $conn->prepare("SELECT qty FROM lumber WHERE lumberId = :itemId");
    $stmt->execute([':itemId' => $itemId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['success' => true, 'maxQty' => $result['qty']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lumber details not found.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
