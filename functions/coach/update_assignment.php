<?php

include_once '../../database/db_connection.php';

if (isset($_POST['id'], $_POST['client_id'], $_POST['coach_id'])) {
    $assignmentId = intval($_POST['id']);
    $clientId = intval($_POST['client_id']);
    $coachId = intval($_POST['coach_id']);

    // Check if the coach is already assigned to this client
    $check_query = "SELECT COUNT(*) FROM client_coach_assignments WHERE client_id = ? AND coach_id = ? AND id != ?";
    $check_stmt = mysqli_prepare($mysqli, $check_query);
    mysqli_stmt_bind_param($check_stmt, 'iii', $clientId, $coachId, $assignmentId);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_bind_result($check_stmt, $count);
    mysqli_stmt_fetch($check_stmt);
    mysqli_stmt_close($check_stmt);

    if ($count > 0) {
        echo 'Error: This coach is already assigned to this client.';
    } else {
        // If not assigned, proceed with the update
        $sql = "UPDATE client_coach_assignments SET client_id = ?, coach_id = ?, assigned_at = NOW() WHERE id = ?";
        $update_stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($update_stmt, 'iii', $clientId, $coachId, $assignmentId);

        if (mysqli_stmt_execute($update_stmt)) {
            echo 'Success';
        } else {
            echo 'Error: ' . mysqli_error($mysqli);
        }
        mysqli_stmt_close($update_stmt);
    }

    mysqli_close($mysqli);
} else {
    echo 'Invalid input';
}
