<?php
//update order table totalAmount based on calculating the qty * unit price + deliveryFee and also handle multiplre items


require_once 'db.php';

$orderId = $_POST['orderId'] ?? 0; // Fallback to 0 if orderId is not available
$dfree = $_POST['dfree'] ?? 0; // Default to 0 if not set

// Step 1: Update delivery fee in orders table
$saveDfreeSql = "UPDATE orders SET deliveryFee = ? WHERE orderId = ?";
$saveStmt = $conn->prepare($saveDfreeSql);
$saveStmt->bind_param("di", $dfree, $orderId);
$saveStmt->execute();
$saveStmt->close();
// Step 2: Update totalAmount in orders table
$sql = "SELECT ofr.qty, ofr.unitPrice 
        FROM orderfurniture ofr 
        WHERE ofr.orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$totalAmount = 0;
$itemCount = 0;
while ($row = $result->fetch_assoc()) {
    $totalAmount += $row['qty'] * $row['unitPrice'];
    $itemCount++; // count each item row
}
$stmt->close();
// Step 3: Apply delivery fee per item
$totalAmount += $dfree * $itemCount; // Add the delivery fee if applicable
// Step 4: Update totalAmount in orders table
////have to calculate the sum of amount in payment tables for each prder id where viewed = '1' and subtract from totalamount
$sql = "SELECT SUM(amount) as totalpaid FROM payment WHERE orderId = ? AND viewed = '1'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$result = $result->fetch_assoc();
$totalAmount -= $result['totalpaid'];

$sql = "UPDATE orders SET totalAmount = ? WHERE orderId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $totalAmount, $orderId);
$stmt->execute();
$stmt->close();
// Step 5: Return the total amount as JSON response
echo json_encode(["status" => "success", "totalAmount" => $totalAmount]);
$conn->close();
// Close the database connection\

?>