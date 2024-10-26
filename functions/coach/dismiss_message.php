<?php
include_once '../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "UPDATE notifications SET is_dismiss = 0 WHERE id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "id" => $id]);
            http_response_code(200);
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
            http_response_code(500);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => "Failed to prepare query"]);
        http_response_code(500);
    }
}