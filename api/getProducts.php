<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include 'db.php';

$query = "
    SELECT 
        f.furnitureId,
        f.description,
        f.image,
        f.category,
        f.type,
        f.size,
        f.additionalDetails,
        f.unitPrice,
        r.review
    FROM furnitures f
    LEFT JOIN orderfurniture ofr ON f.furnitureId = ofr.itemId
    LEFT JOIN review r ON ofr.reviewId = r.reviewId
";

$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => mysqli_error($conn)]);
    exit;
}

// Process and group reviews by furnitureId
$products = [];

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['furnitureId'];

    // Initialize product if not set
    if (!isset($products[$id])) {
        $products[$id] = [
            "furnitureId" => $row["furnitureId"],
            "description" => $row["description"],
            "image" => $row["image"],
            "category" => $row["category"],
            "type" => $row["type"],
            "size" => $row["size"],
            "additionalDetails" => $row["additionalDetails"],
            "unitPrice" => $row["unitPrice"],
            "reviews" => []
        ];
    }

    // Append review if present
    if (!empty($row["review"])) {
        $products[$id]["reviews"][] = $row["review"];
    }
}

// Re-index to simple array
echo json_encode(array_values($products));
?>