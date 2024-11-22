<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $protein = isset($_POST['protein']) ? mysqli_real_escape_string($mysqli, $_POST['protein']) : '';

    if (empty($protein)) {
        echo 'Protein is required';
    } else {
        $checkSql = "SELECT COUNT(*) FROM `protein` WHERE `name` = ?";
        $checkStmt = $mysqli->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("s", $protein);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo 'Protein already exists.';
            } else {
                $insertSql = "INSERT INTO `protein` (name) VALUES (?)";
                $insertStmt = $mysqli->prepare($insertSql);

                if ($insertStmt) {
                    $insertStmt->bind_param("s", $protein);
                    if ($insertStmt->execute()) {
                        echo 'Success';
                    } else {
                        echo 'Error: Could not save Protein';
                    }
                    $insertStmt->close();
                }
            }
        }
    }
} else {
    echo 'Invalid request method.';
}
