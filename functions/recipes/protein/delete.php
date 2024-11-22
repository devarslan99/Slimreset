<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        $query = "DELETE FROM `protein` WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error: Unable to delete the record';
        }

        $stmt->close();
    } else {
        echo 'Invalid ID provided';
    }

    $mysqli->close();
} else {
    echo 'Invalid request method';
}
