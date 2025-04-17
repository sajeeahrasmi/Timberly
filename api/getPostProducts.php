<?php
include 'db.php';

// Query to fetch driver details
$productDataQuery = "SELECT
                    furnitureId,
                    description,
                    category,
                    type,
                    size,
                    unitPrice
                    from furnitures";
$productDataResult = mysqli_query($conn, $productDataQuery);

if (!$productDataResult) {
    die("Error fetching product data. " . mysqli_error($conn));
}

// Fetch all rows into an array
$productData = [];
while ($row = mysqli_fetch_assoc($productDataResult)) {
    $productData[] = $row;
}

?>