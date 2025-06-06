<?php
        include 'db.php';
        $timberDataQuery = "SELECT timberId AS id, type, length , diameter, price, qty, supplierId FROM timber";

        $timberDataResult = mysqli_query($conn, $timberDataQuery);
        if (!$timberDataResult) {
            die("Error fetching timber data: " . mysqli_error($conn));
        }
        $timberData = [];
        while ($row = mysqli_fetch_assoc($timberDataResult)) {
            $timberData[] = $row;
        }
        $lumberDataQuery = "SELECT lumberId AS id, type, length , width , thickness ,unitPrice , qty  FROM lumber WHERE is_deleted = '0'";
$lumberDataResult = mysqli_query($conn, $lumberDataQuery);
if (!$lumberDataResult) {
    die("Error fetching lumber data: " . mysqli_error($conn));
}
$lumberData = [];
while ($row = mysqli_fetch_assoc($lumberDataResult)) {
    $lumberData[] = $row;
}
   

function getMaterialTypes($data) {
    return array_unique(array_column($data, 'type'));
}

$timberMaterialTypes = getMaterialTypes($timberData);
$lumberMaterialTypes = getMaterialTypes($lumberData);
?>