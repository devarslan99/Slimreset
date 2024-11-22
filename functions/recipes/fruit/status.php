<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 0;

    if ($id > 0) {
        $sql = "UPDATE `fruit` SET `status` = ? WHERE `id` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error: Could not update status.';
        }
        $stmt->close();
    } else {
        echo 'Error: Invalid fruit group ID.';
    }
} else {
    echo 'Invalid request method.';
}
