

<?php

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
   
    $material_type = $_POST['material_type'] ;
    $length = $_POST['length'];
    $width = $_POST['width'];
    $thickness = $_POST['thickness'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'] ;
    

    
    if (empty($material_type) || empty($length) || empty($unit_price) || empty($width) || empty($thickness)  || empty($quantity)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $query = "INSERT INTO lumber (type, length, width, thickness , qty , unitPrice) 
              VALUES ('$material_type', '$length', '$width', '$thickness' , '$quantity' , '$unit_price')";
    
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Product created successfully']);
    } else {
        
        echo json_encode(['success' => false, 'message' => 'Error creating product: ' . mysqli_error($conn)]);
    }
}
?>
