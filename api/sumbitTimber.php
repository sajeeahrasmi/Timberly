<?php

include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $material_type = $_POST['material_type'] ;
    $diameter = $_POST['diameter'];
    $unit_price = $_POST['unit_price'] ;
    $supplierId = $_POST['supplierId'] ;

    // Basic validation
    if (empty($material_type) || empty($diameter) || empty($unit_price) || empty($supplierId)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Database insert (assuming you have a table 'timber_products' in your database)
    $stmt = $db->prepare("INSERT INTO timber (type, diameter, price, supplierId) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $material_type, $diameter, $unit_price, $supplierId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to insert into the database.']);
    }

    $stmt->close();
    $db->close();
}
?>
