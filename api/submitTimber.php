

<?php

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
   
    $material_type = $_POST['material_type'] ;
    $diameter = $_POST['diameter'];
    $unit_price = $_POST['unit_price'] ;
    $supplierId = $_POST['supplierId'] ;

    
    if (empty($material_type) || empty($diameter) || empty($unit_price) || empty($supplierId) ) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $query = "INSERT INTO timber (type, price, diameter, supplierId) 
              VALUES ('$material_type', '$unit_price', '$diameter', '$supplierId')";
    
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Product created successfully']);
    } else {
        
        echo json_encode(['success' => false, 'message' => 'Error creating product: ' . mysqli_error($conn)]);
    }
}
?>
