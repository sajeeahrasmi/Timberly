<?php

include 'db.php';

header('Content-Type: application/json');

$response = array(
    'success' => false,
    'message' => 'An error occurred.'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['timberId'])) {
    
    $timberId = intval($_POST['timberId']); 

    $query = "DELETE FROM timber WHERE timberid = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $timberId); 

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = 'Timber item deleted successfully!';
            } else {
                $response['message'] = 'Timber item not found or could not be deleted.';
            }
        } else {
            $response['message'] = 'Failed to execute delete query.';
        }

        $stmt->close(); 
    } else {
        $response['message'] = 'Failed to prepare delete statement.';
    }

    $conn->close(); 
} else {
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>
