<?php
header('Content-Type: application/json');

include 'db.php';

$sql = "SELECT 
    o.orderId, 
    o.date, 
    o.itemQty,
    o.totalAmount, 
    o.status AS orderStatus,
    o.category AS orderCategory,
    o.paymentStatus,
    u.name AS customerName, 
    o.userId AS customerId,

    /* Lumber specific data */
    ol.orderId AS lumberOrderId,
    ol.itemId AS lumberId,
    ol.qty AS lumberQty,
    ol.status AS lumberStatus,
    l.type AS lumberType,

    /* Furniture specific data */
    ofr.orderId AS furnitureOrderId,
    ofr.itemId AS furnitureId,
    ofr.qty AS furnitureQty,
    ofr.status AS furnitureStatus,
    ofr.type AS furnitureWoodType,
    ofr.size AS furnitureSize,
    ofr.additionalDetails AS furnitureDetails,
    ofr.unitPrice AS furniturePrice,
    ofr.description AS furnitureOrderDescription,
    ofr.date AS furnitureOrderDate,
    f.furnitureId AS furnitureTableId,
    f.description AS furnitureDescription,
    f.category AS furnitureCategory,

    /* Customized furniture specific data */
    ocf.orderId AS customOrderId,
    ocf.itemId AS customItemId,
    ocf.description AS customDescription,
    ocf.type AS customWoodType,
    ocf.length AS customLength,
    ocf.width AS customWidth,
    ocf.thickness AS customThickness,
    ocf.qty AS customQty,
    ocf.frame AS customFrame,
    CASE
        WHEN ocf.unitPrice IS NULL OR ocf.unitPrice = 0 THEN 'To be decided'
        ELSE ocf.unitPrice
    END AS customUnitPrice,
    ocf.status AS customStatus,
    ocf.deliveryId AS customDeliveryId,
    ocf.date AS customOrderDate,
    ocf.image AS customImage,

    /* Helper field to identify the type of product in this row */
    CASE 
        WHEN ol.orderId IS NOT NULL THEN 'Lumber'
        WHEN ofr.orderId IS NOT NULL THEN 'Furniture'
        WHEN ocf.orderId IS NOT NULL THEN 'Customized_Furniture'
        ELSE NULL
    END AS productType

FROM orders o
LEFT JOIN user u ON o.userId = u.userId

/* Lumber related join */
LEFT JOIN orderlumber ol ON o.orderId = ol.orderId
LEFT JOIN lumber l ON ol.itemId = l.lumberId

/* Furniture related join */
LEFT JOIN orderfurniture ofr ON o.orderId = ofr.orderId
LEFT JOIN furnitures f ON ofr.itemId = f.furnitureId

/* Customized furniture related join */
LEFT JOIN ordercustomizedfurniture ocf ON o.orderId = ocf.orderId

/* We want at least one product related to the order */
WHERE ol.orderId IS NOT NULL OR ofr.orderId IS NOT NULL OR ocf.orderId IS NOT NULL;
";

$result = $conn->query($sql);

$orders = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Directly push the row into the $orders array
        $orders[] = $row;
    }
}

// REMOVE THIS LINE - it outputs text before the JSON
// echo $orders[0]["furnitureId"];

// Send JSON response
echo json_encode($orders);

$conn->close();
?>