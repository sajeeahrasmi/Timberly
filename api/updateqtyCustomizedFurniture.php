<?php
//upadte the quantity of the furniture item in the orderfurniture table
// and also update the itemQty in the orders table

require_once 'db.php';
$orderId = $_POST['orderId'];
$itemId = $_POST['itemId'];
$qty = $_POST['quantity'] ?? 0; // Default to 0 if not set

 // Default to 0 if not set

// Step 1: Update qty in orderfurniture
$stmt = $conn->prepare("UPDATE ordercustomizedfurniture SET qty = ? WHERE orderId = ? AND itemId = ?");
$stmt->bind_param("iii", $qty, $orderId, $itemId);
$success1 = $stmt->execute();
$stmt->close();
// Step 2: Update itemQty in orders table
$stmt2 = $conn->prepare("
    UPDATE orders 
    SET itemQty = (
        SELECT SUM(qty) 
        FROM ordercustomizedfurniture 
        WHERE orderId = ?
    ) 
    WHERE orderId = ?
");
$stmt2->bind_param("ii", $orderId, $orderId);
$success2 = $stmt2->execute();
$stmt2->close();







//check everything is ok 

if ($success1 && $success2) {
    echo "Quantity updated successfully";
} else {
    echo "Failed to update quantity";
}
$conn->close();

    


?>