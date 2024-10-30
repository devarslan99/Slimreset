<?php
include_once '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $table_name = $_POST['table_name'];

    $deleteSQL = "DELETE FROM $table_name WHERE id = ?";
    $deleteStmt = $mysqli->prepare($deleteSQL);
    $deleteStmt->bind_param('s', $id);

    if ($deleteStmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
} else {
    echo "Invalid request";
}
?>
