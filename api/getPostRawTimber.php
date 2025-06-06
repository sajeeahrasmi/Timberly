<?php
    include 'db.php';

    // Pagination setup
    $ordersPerPage = 6;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $ordersPerPage;

    // Get total number of orders
    $totalOrdersQuery = "SELECT COUNT(*) as total FROM timber";
    $totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
    $totalOrdersRow = mysqli_fetch_assoc($totalOrdersResult);
    $totalOrders = $totalOrdersRow['total'];
    $totalPages = ceil($totalOrders / $ordersPerPage);

    // Query to fetch driver details
    $productDataQuery = "SELECT * from timber LIMIT $ordersPerPage OFFSET $offset";
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