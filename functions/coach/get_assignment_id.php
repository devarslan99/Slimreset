<?php
include_once '../../database/db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "
        SELECT cca.client_id, cca.coach_id, 
               CONCAT(c.first_name, ' ', c.last_name) AS client_name, 
               CONCAT(co.first_name, ' ', co.last_name) AS coach_name 
        FROM client_coach_assignments cca 
        JOIN users c ON cca.client_id = c.id 
        JOIN users co ON cca.coach_id = co.id 
        WHERE cca.id = $id 
        LIMIT 1
    ";

    $result = mysqli_query($mysqli, $sql);
    $assignment = mysqli_fetch_assoc($result);

    if ($assignment) {
        echo json_encode($assignment);
    } else {
        echo json_encode(['error' => 'No assignment found']);
    }

    mysqli_free_result($result);
} else {
    echo json_encode(['error' => 'ID not provided']);
}

mysqli_close($mysqli);
