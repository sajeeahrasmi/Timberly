<?php
// api/deleteInventory.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $type = $data['type']; // 'timber' or 'lumber'
    $id = intval($data['id']);

    // Set the table and ID column based on the type
    if ($type === 'timber') {
        $table = 'timber';
        $idColumn = 'timberid';
    } elseif ($type === 'lumber') {
        $table = 'lumber';
        $idColumn = 'lumberid';
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid type']);
        exit;
    }

    // Prepare and execute the delete query
    $query = "DELETE FROM $table WHERE $idColumn = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete item']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare the query']);
    }

    // Close the connection
    $conn->close();
}
?>
