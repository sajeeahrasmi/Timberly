<?php
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Set header to return JSON
    header('Content-Type: application/json');

    // Include database connection
    include 'db.php'; // Make sure this file exists and connects to $conn

    // Your SQL query to fetch product details
    $query = "SELECT
        furnitureId,
        description,
        image,
        category,
        type,
        size,
        additionalDetails,
        unitPrice
    FROM furnitures";

    // Execute query
    $result = mysqli_query($conn, $query);

    // Handle query failure
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => mysqli_error($conn)]);
        exit;
    }

    // Collect data
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    // Output JSON
    echo json_encode($products);
?>