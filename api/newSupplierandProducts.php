<?php
function getSuppliersFromDatabase() {
    include 'db.php';
    $sql = "SELECT * FROM user WHERE status = 'Not Approved'";  // Adjust query as needed
    $result = $conn->query($sql);

    $suppliers = [];
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }

    $conn->close();
    return $suppliers;
}

$suppliers = getSuppliersFromDatabase(); // Fetch suppliers from the database

    // Mock product data based on suppliers
 
    $products = [
        ['id' => 1, 'name' => 'Product 1', 'supplier_id' => 1, 'status' => 'Not Approved' , 'details' => 'Nice Product'],
        ['id' => 2, 'name' => 'Product 2', 'supplier_id' => 1, 'status' => 'Not Approved' , 'details' => 'Good Product'],
        ['id' => 3, 'name' => 'Product 3', 'supplier_id' => 2, 'status' => 'Not Approved' , 'details' => 'Great Product'],
        ['id' => 4, 'name' => 'Product 4', 'supplier_id' => 2, 'status' => 'Not Approved' , 'details' => 'Nice Product'],
        ['id' => 5, 'name' => 'Product 5', 'supplier_id' => 3, 'status' => 'Approved' ,'details' => 'Bad Product'], ]
    ?>
    