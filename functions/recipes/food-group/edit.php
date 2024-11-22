<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $foodGroup = isset($_POST['foodGroup']) ? mysqli_real_escape_string($mysqli, $_POST['foodGroup']) : '';

    if ($id && !empty($foodGroup)) {
        $query = "UPDATE `food-group` SET `name` = ? WHERE `id` = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $foodGroup, $id);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error: Could not update food group.';
        }
        $stmt->close();
    } else {
        echo 'Error: Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
