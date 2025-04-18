<?php
// Authentication check (if any)

// Database connection
require_once 'db.php';

// Initialize response array
$response = array();

try {
    // SQL query
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

    // Run the query
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }

        // Output as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        throw new Exception("Query error: " . $conn->error);
    }

} catch (Exception $e) {
    // Return error
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
