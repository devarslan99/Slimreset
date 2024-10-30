<?php
include_once '../../database/db_connection.php';

if (isset($_POST['id'])) {
    $assignmentId = $_POST['id'];

    $sql = "DELETE FROM client_coach_assignments WHERE id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $assignmentId);
        if ($stmt->execute()) {
            echo 'Success';
        } else {
            echo 'Error';
        }
        $stmt->close();
    } else {
        echo 'Error';
    }
} else {
    echo 'Invalid ID';
}

mysqli_close($mysqli);
