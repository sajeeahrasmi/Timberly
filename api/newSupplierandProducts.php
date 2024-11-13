<?php
// Mock data for suppliers
$suppliers = [
    ['id' => 1, 'name' => 'Supplier A', 'status' => 'pending', 'address' => '123 Main St', 'contact' => '123-456-7890'],
    ['id' => 2, 'name' => 'Supplier B', 'status' => 'pending', 'address' => '456 Oak St', 'contact' => '987-654-3210'],
    ['id' => 3, 'name' => 'Supplier C', 'status' => 'approved', 'address' => '789 Pine St', 'contact' => '555-555-5555'],
];

// Mock data for products
$products = [
    ['id' => 1, 'name' => 'Product X', 'status' => 'pending', 'supplier_id' => 1, 'details' => 'High quality product X', 'photo' => 'path/to/product_x.jpg'],
    ['id' => 2, 'name' => 'Product Y', 'status' => 'pending', 'supplier_id' => 2, 'details' => 'Durable product Y', 'photo' => 'path/to/product_y.jpg'],
    ['id' => 3, 'name' => 'Product Z', 'status' => 'approved', 'supplier_id' => 1, 'details' => 'Affordable product Z', 'photo' => 'path/to/product_z.jpg'],
    ['id' => 4, 'name' => 'Product A', 'status' => 'pending', 'supplier_id' => 1, 'details' => 'Best value product A', 'photo' => 'path/to/product_a.jpg'], // Added a second product for Supplier A
];

// Function to handle approval/rejection
function handleFormSubmission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['approve_supplier'])) {
            echo "<script>alert('Supplier " . $_POST['supplier_id'] . " approved');</script>";
        } elseif (isset($_POST['reject_supplier'])) {
            echo "<script>alert('Supplier " . $_POST['supplier_id'] . " rejected');</script>";
        } elseif (isset($_POST['approve_product'])) {
            echo "<script>alert('Product " . $_POST['product_id'] . " approved');</script>";
        } elseif (isset($_POST['reject_product'])) {
            echo "<script>alert('Product " . $_POST['product_id'] . " rejected');</script>";
        }
    }
}

// Call the function to handle any form submissions
handleFormSubmission();
?>
