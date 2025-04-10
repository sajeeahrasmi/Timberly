<?php
include 'db.php';

// Fetch total orders
$orderQuery = "SELECT COUNT(*) AS totalOrders FROM orders";
$orderResult = mysqli_query($conn, $orderQuery);
$totalOrders = mysqli_fetch_assoc($orderResult)['totalOrders'];

// Fetch total suppliers
$supplierQuery = "SELECT COUNT(*) AS totalSuppliers FROM user WHERE role='supplier'";
$supplierResult = mysqli_query($conn, $supplierQuery);
$totalSuppliers = mysqli_fetch_assoc($supplierResult)['totalSuppliers'];

// Fetch total customers
$customerQuery = "SELECT COUNT(*) AS totalCustomers FROM user WHERE role='customer'";
$customerResult = mysqli_query($conn, $customerQuery);
$totalCustomers = mysqli_fetch_assoc($customerResult)['totalCustomers'];

// Fetch total posts
$postQuery = "SELECT COUNT(*) AS totalPosts FROM products";
$postResult = mysqli_query($conn, $postQuery);
$totalPosts = mysqli_fetch_assoc($postResult)['totalPosts'];
?>