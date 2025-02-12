<?php

header('Content-Type: application/json');
require_once 'db.php';

try {
    
    $id = $_POST['id'];
    $type = $_POST['type'];
    $newQty = $_POST['quantity'];
    
   
    if ($type === 'timber') {
        $table = 'timber';
        $idColumn = 'timberId';  
    } else {
        $table = 'lumber';
        $idColumn = 'lumberId';  
    }
    
   
    $sql = "UPDATE $table SET qty = ? WHERE $idColumn = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "di", $newQty, $id);
    
    if(mysqli_stmt_execute($stmt)) {
        if(mysqli_affected_rows($conn) > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Updated successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No rows were updated'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Update query failed: ' . mysqli_error($conn)
        ]);
    }

    mysqli_stmt_close($stmt);

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

mysqli_close($conn);
?>