<?php
include_once __DIR__ . '/../../database/db_connection.php';

$response = ['success' => false, 'id' => null, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the message ID from the AJAX request
    $message_id = isset($_POST['id']) ? intval($_POST['id']) : null;

    if ($message_id) {
        // Update the is_read status to 1 for the given message ID
        $stmt = $mysqli->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");

        if ($stmt) {
            $stmt->bind_param("i", $message_id);
            $success = $stmt->execute();
            $stmt->close();

            if ($success) {
                $response['success'] = true;
                $response['id'] = $message_id; // Return the message ID for client-side reference
            } else {
                $response['error'] = 'Failed to update the message status.';
            }
        } else {
            $response['error'] = 'Failed to prepare the SQL statement.';
        }
    } else {
        $response['error'] = 'Invalid message ID.';
    }
} else {
    $response['error'] = 'Invalid request method.';
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
