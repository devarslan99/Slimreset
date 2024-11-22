<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foodGroup = isset($_POST['foodGroup']) ? mysqli_real_escape_string($mysqli, $_POST['foodGroup']) : '';

    if (empty($foodGroup)) {
        echo 'Food group is required';
    } else {
        $checkSql = "SELECT COUNT(*) FROM `food-group` WHERE `name` = ?";
        $checkStmt = $mysqli->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("s", $foodGroup);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo 'Food group already exists.';
            } else {
                $insertSql = "INSERT INTO `food-group` (name) VALUES (?)";
                $insertStmt = $mysqli->prepare($insertSql);

                if ($insertStmt) {
                    $insertStmt->bind_param("s", $foodGroup);
                    if ($insertStmt->execute()) {
                        echo 'Success';
                    } else {
                        echo 'Error: Could not save Food group';
                    }
                    $insertStmt->close();
                }
            }
        }
    }
} else {
    echo 'Invalid request method.';
}
