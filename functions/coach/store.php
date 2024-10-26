<?php
include_once '../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_POST['client_id'];
    $coach_id = $_POST['coach_id'];

    if (!empty($client_id) && !empty($coach_id)) {
        // First, check if the coach is already assigned to the client
        $check_query = "SELECT COUNT(*) FROM client_coach_assignments WHERE client_id = ? AND coach_id = ?";
        $check_stmt = mysqli_prepare($mysqli, $check_query);
        mysqli_stmt_bind_param($check_stmt, 'ii', $client_id, $coach_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $count);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if ($count > 0) {
            echo 'Error: This coach is already assigned to this client.';
        } else {
            // If not assigned, proceed with the insert
            $insert_query = "INSERT INTO client_coach_assignments (client_id, coach_id, assigned_at) VALUES (?, ?, NOW())";
            $stmt = mysqli_prepare($mysqli, $insert_query);
            mysqli_stmt_bind_param($stmt, 'ii', $client_id, $coach_id);

            if (mysqli_stmt_execute($stmt)) {
                echo 'Success';
            } else {
                echo 'Error: Could not assign coach to client.';
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo 'Error: Both client and coach must be selected.';
    }
}
mysqli_close($mysqli);
