<?php
session_start(); // Ensure session is started

include_once __DIR__ . '/../../database/db_connection.php';

// Check for session values
if (!isset($_SESSION['user_id'], $_SESSION['role'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid session data']);
    exit;
}

$user_one_id = intval($_SESSION['user_id']);
$login_user_role = $_SESSION['role'];
$user_two_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

if ($login_user_role == 'coach') {
    if (!$user_two_id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID in URL']);
        exit;
    }

    // Coach assigned to client validation
    $query = "SELECT * FROM client_coach_assignments WHERE coach_id = ? AND client_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $user_one_id, $user_two_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'You are not assigned to this client']);
        exit;
    }
    // echo json_encode(['status' => 'success', 'message' => 'Chat is allowed']);
} elseif ($login_user_role == 'client') {
    // Client assigned coach validation
    $query = "SELECT coach_id FROM client_coach_assignments WHERE client_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_one_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_two_id = $row['coach_id'];
        // echo json_encode(['status' => 'success', 'message' => 'Chat is allowed']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No coach is assigned to you']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized user role']);
    exit;
}
