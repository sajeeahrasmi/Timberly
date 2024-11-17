<?php

include('db.php');  

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $category = $_GET['category'] ?? '';
    $productName = $_GET['productName'] ?? '';

    switch ($category) {
        case 'rtimber':
            $query = "SELECT * FROM timber WHERE timberId = '$productName'";
            break;
        case 'rlumber':
            $query = "SELECT * FROM lumber WHERE lumberId = '$productName'"; 
            break;
        case 'ffurniture':
        case 'ddoorsandwindows':
            $query = "SELECT * FROM products WHERE productId = '$productName'";
            break;
        default:
            $query = ''; 
            break;
    }

    if ($query) {
        
        $result = mysqli_query($conn, $query); 

        
        if ($result) {
            $product = mysqli_fetch_assoc($result);
            echo json_encode($product);  
        } else {
            echo json_encode([]); 
        }
    } else {
        echo json_encode([]);  
    }
}
?>
