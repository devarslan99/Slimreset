<?php
include_once '../../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mealType = isset($_POST['mealType']) ? mysqli_real_escape_string($mysqli, $_POST['mealType']) : '';

    if (empty($mealType)) {
        echo 'Meal Type is required';
    } else {
        $checkSql = "SELECT COUNT(*) FROM `meal-type` WHERE `name` = ?";
        $checkStmt = $mysqli->prepare($checkSql);

        if ($checkStmt) {
            $checkStmt->bind_param("s", $mealType);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                echo 'Meal Type already exists.';
            } else {
                $insertSql = "INSERT INTO `meal-type` (name) VALUES (?)";
                $insertStmt = $mysqli->prepare($insertSql);

                if ($insertStmt) {
                    $insertStmt->bind_param("s", $mealType);
                    if ($insertStmt->execute()) {
                        echo 'Success';
                    } else {
                        echo 'Error: Could not save Meal Type';
                    }
                    $insertStmt->close();
                }
            }
        }
    }
} else {
    echo 'Invalid request method.';
}
