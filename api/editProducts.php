<?php
// Assuming you have a database connection set up using mysqli
include('db.php');  // Ensure db.php contains your database connection setup

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Sanitize and get the category and productName from GET request
    $category = $_GET['category'] ?? '';
    $productName = $_GET['productName'] ?? '';

    // Create a switch case based on the category
    switch ($category) {
        case 'rtimber':
            $query = "SELECT * FROM timber WHERE timberId = '$productName'";
            break;
        case 'rlumber':
            $query = "SELECT * FROM lumber WHERE lumberId = '$productName'"; // Fixed typo here
            break;
        case 'ffurniture':
        case 'ddoorsandwindows':
            $query = "SELECT * FROM products WHERE productId = '$productName'";
            break;
        default:
            $query = '';  // Default if category is unknown
            break;
    }

    // Check if the query is set
    if ($query) {
        // Execute the query using mysqli
        $result = mysqli_query($conn, $query);  // Assuming $conn is your mysqli connection

        // Check if a product was found
        if ($result) {
            $product = mysqli_fetch_assoc($result);
            echo json_encode($product);  // Return product as JSON
        } else {
            echo json_encode([]);  // Return empty array if no product found
        }
    } else {
        echo json_encode([]);  // Return empty array if category is not valid
    }
}
?>
