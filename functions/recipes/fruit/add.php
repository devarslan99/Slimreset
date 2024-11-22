<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fruit = isset($_POST['fruit']) ? mysqli_real_escape_string($mysqli, $_POST['fruit']) : '';

    if (empty($fruit)) {
        echo 'Fruit is required';
    } else {
        $checkSql = "SELECT COUNT(*) FROM `fruit` WHERE `name` = ?";
        $checkStmt = $mysqli->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("s", $fruit);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo 'Fruit already exists.';
            } else {
                $insertSql = "INSERT INTO `fruit` (name) VALUES (?)";
                $insertStmt = $mysqli->prepare($insertSql);

                if ($insertStmt) {
                    $insertStmt->bind_param("s", $fruit);
                    if ($insertStmt->execute()) {
                        echo 'Success';
                    } else {
                        echo 'Error: Could not save fruit';
                    }
                    $insertStmt->close();
                }
            }
        }
    }
} else {
    echo 'Invalid request method.';
}
