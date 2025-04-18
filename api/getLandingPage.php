<?php
    include 'db.php';

    $query = "SELECT furnitureId, description, image FROM furnitures WHERE category IN ('Door', 'Window', 'Transom')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching product data. " . mysqli_error($conn));
    }

    $productData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $productData[] = $row;
    }

?>