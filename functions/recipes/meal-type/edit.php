<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $mealType = isset($_POST['mealType']) ? mysqli_real_escape_string($mysqli, $_POST['mealType']) : '';

    if ($id && !empty($mealType)) {
        $query = "UPDATE `meal-type` SET `name` = ? WHERE `id` = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $mealType, $id);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error: Could not update meal type.';
        }
        $stmt->close();
    } else {
        echo 'Error: Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
