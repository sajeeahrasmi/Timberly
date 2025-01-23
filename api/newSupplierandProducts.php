<?php
function getSuppliersFromDatabase() {
    include 'db.php';
    $sql = "SELECT * FROM user WHERE status = 'Not Approved'";  // Adjust query as needed
    $result = $conn->query($sql);

    $suppliers = [];
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }

    $conn->close();
    return $suppliers;
}

$suppliers = getSuppliersFromDatabase(); // Fetch suppliers from the database

    // Mock product data based on suppliers
 
    $products = [
        [
            'id' => 1,
            'name' => 'Nedum',
            'supplier_id' => 304,
            'supplier_address' => '123 Mathara Rd, Mathara', // Added supplier address
            'unit_price' => 1250.50, // Added unit price
            'status' => 'Not Approved',
            'details' => 'Nice Product'
        ],
        [
            'id' => 2,
            'name' => 'Sooriyam',
            'supplier_id' => 203,
            'supplier_address' => '123 Ambillawtta Rd, Boralasgamuwa', // Added supplier address
            'unit_price' => 1833.75, // Added unit price
            'status' => 'Not Approved',
            'details' => 'Good Product'
        ],
        [
            'id' => 3,
            'name' => 'Teak',
            'supplier_id' => 201,
            'supplier_address' => '456 Kabes Rd, Kurunegala', // Added supplier address
            'unit_price' => 3000.00, // Added unit price
            'status' => 'Not Approved',
            'details' => 'Great Product'
        ],
        [
            'id' => 4,
            'name' => 'Jak',
            'supplier_id' => 206,
            'supplier_address' => '456 Timbirigasyaya,Colombo', // Added supplier address
            'unit_price' => 22.10, // Added unit price
            'status' => 'Not Approved',
            'details' => 'Nice Product'
        ],
        [
            'id' => 5,
            'name' => 'Product 5',
            'supplier_id' => 302,
            'supplier_address' => '789 Supplier Rd, Village, Country', // Added supplier address
            'unit_price' => 15.50, // Added unit price
            'status' => 'Approved',
            'details' => 'Bad Product'
        ]
    ];
    