<?php
        include 'db.php';
$timberDataQuery = "SELECT timberId, type, length , diameter, price, supplierId ,image_path , qty FROM timber";
$timberDataResult = mysqli_query($conn, $timberDataQuery);
if (!$timberDataResult) {
    die("Error fetching timber data: " . mysqli_error($conn));
}
$timberData = [];
while ($row = mysqli_fetch_assoc($timberDataResult)) {
    $timberData[] = $row;
}
// Fetching Lumber Data
$lumberDataQuery = "SELECT lumberId, type, length, width, thickness, qty, unitPrice ,image_path FROM lumber WHERE is_deleted = '0'";
$lumberDataResult = mysqli_query($conn, $lumberDataQuery);
if (!$lumberDataResult) {
    die("Error fetching lumber data: " . mysqli_error($conn));
}
$lumberData = [];
while ($row = mysqli_fetch_assoc($lumberDataResult)) {
    $lumberData[] = $row;
}
   
     
 // Fetching Furniture Data
 $furnitureDataQuery = "SELECT furnitureId, description,category, type,size,additionalDetails, unitPrice , image FROM furnitures WHERE category in ('Chair','Table','Wardrobe','Bookshelf','Stool')";
$furnitureDataResult = mysqli_query($conn, $furnitureDataQuery); 
if (!$furnitureDataResult) {
    die("Error fetching furniture data: " . mysqli_error($conn)); 
}
$furnitureData = [];
while ($row = mysqli_fetch_assoc($furnitureDataResult)) {
    $furnitureData[] = $row;
}
// Fetching Doors and Windows Data
$doorsAndwindowsDataQuery = "SELECT furnitureId, description,category, type,size,additionalDetails, unitPrice , image FROM furnitures WHERE category in ('Door','Window' , 'Transom')";
$doorsAndwindowsDataResult = mysqli_query($conn, $doorsAndwindowsDataQuery);
if (!$doorsAndwindowsDataResult) {
    die("Error fetching doors and windows data: " . mysqli_error($conn));
}
$doorsAndwindowsData = [];
while ($row = mysqli_fetch_assoc($doorsAndwindowsDataResult)) {
    $doorsAndwindowsData[] = $row;
}
?>