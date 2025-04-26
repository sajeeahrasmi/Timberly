<?php



require_once 'db.php';


$response = array();

try {
    
    $sql = "
    SELECT 
        CASE 
            WHEN category = 'CustomisedFurniture' THEN 'Furniture'
            ELSE category 
        END AS category, 
        SUM(totalAmount) AS sales
    FROM orders
    WHERE status = 'Completed'
    GROUP BY 
        CASE 
            WHEN category = 'CustomisedFurniture' THEN 'Furniture' 
            ELSE category 
        END
    ORDER BY sales DESC
    ";

   
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }

        
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        throw new Exception("Query error: " . $conn->error);
    }

} catch (Exception $e) {
    
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
