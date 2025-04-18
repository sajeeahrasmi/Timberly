<?php
    include 'db.php';

    // Query to fetch driver details
    $productDataQuery = "SELECT * from timber";
    $productDataResult = mysqli_query($conn, $productDataQuery);

    if (!$productDataResult) {
        die("Error fetching timber data. " . mysqli_error($conn));
    }

    // Fetch all rows into an array
    $productData = [];
    while ($row = mysqli_fetch_assoc($productDataResult)) {
        $productData[] = $row;
    }
?>