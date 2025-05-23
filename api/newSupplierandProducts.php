<?php
function getSuppliersFromDatabase() {
    include 'db.php';
    $sql = "SELECT * FROM user WHERE status = 'Not Approved'";  
    $result = $conn->query($sql);

    $suppliers = [];
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }

    $conn->close();
    return $suppliers;
}

$suppliers = getSuppliersFromDatabase(); 

    
 
    
function getPendingProductsFromDatabase() {
    include 'db.php';

    $products = [];

   
    $sqlTimber = "SELECT * FROM pendingtimber WHERE status= 'Pending'";
    $resultTimber = $conn->query($sqlTimber);

    while ($row = $resultTimber->fetch_assoc()) {
        $products[] = [
            'id' => $row['id'],
            'name' => $row['type'],
            'category' => 'timber',
            'supplier_id' => $row['supplierId'],
            'unit_price' => $row['unitprice'], 
            'status' => $row['status'],
            'details' => $row['info'],
            'type' => 'timber',
            'supplier_id' => $row['supplierId'],
            'image' => $row['image'],
            'postdate' => $row['postdate'],
            'quantity' => $row['quantity'],
            
                'diameter' => $row['diameter']
            
        ];
    }

    
    $sqlLumber = "SELECT * FROM pendinglumber WHERE status = 'Pending'";
    $resultLumber = $conn->query($sqlLumber);

    while ($row = $resultLumber->fetch_assoc()) {
        $products[] = [
            'id' => $row['id'],
            'name' => $row['type'],
            'supplier_id' => $row['supplierId'],
            'unit_price' => $row['unitprice'],
            'status' =>  $row['status'],
            'details' => $row['info'],
            'category' => 'lumber',
            'supplier_id' => $row['supplierId'],
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