<?php

include_once __DIR__ . '/../../database/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_user_id = isset($_POST['from_user_id']) ? intval($_POST['from_user_id']) : null;
    $to_user_id = isset($_POST['to_user_id']) ? intval($_POST['to_user_id']) : null;

    if ($from_user_id && $to_user_id) {
        $query = "
            UPDATE messages 
            SET is_read = 1 
            WHERE receiver_id = ? 
            AND sender_id = ? 
            AND is_read = 0";

        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to prepare statement',
                'error' => $mysqli->error
            ]);
            exit;
        }

        $stmt->bind_param("ii", $from_user_id, $to_user_id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Messages successfully marked as read']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update messages', 'error' => $stmt->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
}
