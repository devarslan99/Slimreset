<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $veggie = isset($_POST['veggie']) ? mysqli_real_escape_string($mysqli, $_POST['veggie']) : '';

    if (empty($veggie)) {
        echo 'Veggie is required';
    } else {
        $checkSql = "SELECT COUNT(*) FROM `veggie` WHERE `name` = ?";
        $checkStmt = $mysqli->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("s", $veggie);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo 'Veggie already exists.';
            } else {
                $insertSql = "INSERT INTO `veggie` (name) VALUES (?)";
                $insertStmt = $mysqli->prepare($insertSql);

                if ($insertStmt) {
                    $insertStmt->bind_param("s", $veggie);
                    if ($insertStmt->execute()) {
                        echo 'Success';
                    } else {
                        echo 'Error: Could not save veggie';
                    }
                    $insertStmt->close();
                }
            }
        }
    }
} else {
    echo 'Invalid request method.';
}
