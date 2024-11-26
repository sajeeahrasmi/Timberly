<?php
// Mock data for drivers
$drivers = [
    [
        "driverId" => 101,
        "vehicleNo" => "AB1234",
        "driverName" => "John Smith"
    ],
    [
        "driverId" => 102,
        "vehicleNo" => "XY5678",
        "driverName" => "Alice Johnson"
    ],
    [
        "driverId" => 103,
        "vehicleNo" => "PQ3456",
        "driverName" => "Robert Brown"
    ],
    [
        "driverId" => 104,
        "vehicleNo" => "MN8901",
        "driverName" => "Emma Davis"
    ],
    [
        "driverId" => 105,
        "vehicleNo" => "KL2345",
        "driverName" => "Michael Wilson"
    ]
];

echo json_encode($drivers);
?>
