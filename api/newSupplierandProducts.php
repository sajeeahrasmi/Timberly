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
 
    
function getPendingProductsFromDatabase() {
    include 'db.php';

    $products = [];

    // Fetch from pendingtimber
    $sqlTimber = "SELECT * FROM pendingtimber WHERE is_approved = '0'";
    $resultTimber = $conn->query($sqlTimber);

    while ($row = $resultTimber->fetch_assoc()) {
        $products[] = [
            'id' => $row['timberId'],
            'name' => $row['type'],
            'category' => 'timber',
            'supplier_id' => $row['supplierId'],
            'unit_price' => $row['unitprice'], // Timber has no unit price
            'status' => $row['is_approved'],
            'details' => $row['info'],
            'type' => 'timber',
            'image' => $row['image'],
            'postdate' => $row['postdate'],
            'quantity' => $row['quantity'],
            
                'diameter' => $row['diameter']
            
        ];
    }

    // Fetch from pendinglumber
    $sqlLumber = "SELECT * FROM pendinglumber WHERE is_approved = '0'";
    $resultLumber = $conn->query($sqlLumber);

    while ($row = $resultLumber->fetch_assoc()) {
        $products[] = [
            'id' => $row['lumberId'],
            'name' => $row['type'],
            'supplier_id' => $row['supplierId'],
            'unit_price' => $row['unitprice'],
            'status' =>  $row['is_approved'],
            'details' => $row['info'],
            'category' => 'lumber',
            //'type' => $row['type'],
            'image' => $row['image'],
            'postdate' => $row['postdate'],
            'quantity' => $row['quantity'],
            
                'length' => $row['length'],
                'width' => $row['width'],
                'thickness' => $row['thickness']
            
        ];
    }

    $conn->close();
    return $products;
}

$products = getPendingProductsFromDatabase();