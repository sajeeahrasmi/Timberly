<?php
function getDeliveryHistory($conn, $userId) {
    $history = [];

    $sql = "
        SELECT orderId, itemId, description, type, qty, size, additionalDetails, unitPrice, date
        FROM orderfurniture
        WHERE status = 'delivered' AND driverId = ?
        UNION
        SELECT orderId, itemId, details AS description, type, qty,
            CONCAT(length, 'x', width, 'x', thickness) AS size,
            category AS additionalDetails, unitPrice, date
        FROM ordercustomizedfurniture
        WHERE status = 'delivered' AND driverId = ?
        UNION
        SELECT orderId, itemId, '' AS description, 'Lumber' AS type, qty,
            '' AS size, '' AS additionalDetails, 0 AS unitPrice, date
        FROM orderlumber
        WHERE status = 'delivered' AND driverId = ?
        ORDER BY date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $userId, $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $orderId = $row['orderId'];
        if (!isset($history[$orderId])) {
            $history[$orderId] = [];
        }
        $history[$orderId][] = $row;
    }

    return $history;
}
?>
