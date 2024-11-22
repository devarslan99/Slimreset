<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $protein = isset($_POST['protein']) ? mysqli_real_escape_string($mysqli, $_POST['protein']) : '';

    if ($id && !empty($protein)) {
        $query = "UPDATE `protein` SET `name` = ? WHERE `id` = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $protein, $id);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error: Could not update protein.';
        }
        $stmt->close();
    } else {
        echo 'Error: Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
