<?php
        include 'db.php';
$timberDataQuery = "SELECT timberId, type, diameter, price, supplierId ,image_path FROM timber";
$timberDataResult = mysqli_query($conn, $timberDataQuery);
if (!$timberDataResult) {
    die("Error fetching timber data: " . mysqli_error($conn));
}
$timberData = [];
while ($row = mysqli_fetch_assoc($timberDataResult)) {
    $timberData[] = $row;
}
// Fetch Lumber Data
$lumberDataQuery = "SELECT lumberId, type, length, width, thickness, qty, unitPrice ,image_path FROM lumber WHERE is_deleted = '0'";
$lumberDataResult = mysqli_query($conn, $lumberDataQuery);
if (!$lumberDataResult) {
    die("Error fetching lumber data: " . mysqli_error($conn));
}
$lumberData = [];
while ($row = mysqli_fetch_assoc($lumberDataResult)) {
    $lumberData[] = $row;
}
   
     
 // Fetch Furniture Data
 $furnitureDataQuery = "SELECT productId, description, type, price, review , image_path FROM products WHERE categories = 'furniture'";
$furnitureDataResult = mysqli_query($conn, $furnitureDataQuery); 
if (!$furnitureDataResult) {
    die("Error fetching furniture data: " . mysqli_error($conn)); 
}
$furnitureData = [];
while ($row = mysqli_fetch_assoc($furnitureDataResult)) {
    $furnitureData[] = $row;
}
// Fetch Doors and Windows Data
$doorsAndwindowsDataQuery = "SELECT productId, description, type, price, review , image_path FROM products WHERE categories = 'doorsandwindows'";
$doorsAndwindowsDataResult = mysqli_query($conn, $doorsAndwindowsDataQuery);
if (!$doorsAndwindowsDataResult) {
    die("Error fetching doors and windows data: " . mysqli_error($conn));
}
$doorsAndwindowsData = [];
while ($row = mysqli_fetch_assoc($doorsAndwindowsDataResult)) {
    $doorsAndwindowsData[] = $row;
}
?>