<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $fruit = isset($_POST['fruit']) ? mysqli_real_escape_string($mysqli, $_POST['fruit']) : '';

    if ($id && !empty($fruit)) {
        $query = "UPDATE `fruit` SET `name` = ? WHERE `id` = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $fruit, $id);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error: Could not update fruit.';
        }
        $stmt->close();
    } else {
        echo 'Error: Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
