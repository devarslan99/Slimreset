<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $veggie = isset($_POST['veggie']) ? mysqli_real_escape_string($mysqli, $_POST['veggie']) : '';

    if ($id && !empty($veggie)) {
        $query = "UPDATE `veggie` SET `name` = ? WHERE `id` = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $veggie, $id);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error: Could not update veggie.';
        }
        $stmt->close();
    } else {
        echo 'Error: Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
