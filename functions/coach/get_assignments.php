<?php
include_once '../../database/db_connection.php';

$sql = "
    SELECT 
        cca.id,cca.assigned_at,
        CONCAT(c.first_name, ' ', c.last_name) AS client_name,
        CONCAT(co.first_name, ' ', co.last_name) AS coach_name
    FROM client_coach_assignments cca
    JOIN users c ON cca.client_id = c.id
    JOIN users co ON cca.coach_id = co.id
    ORDER BY cca.assigned_at DESC
";

$result = mysqli_query($mysqli, $sql);
$assignments = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $assignments[] = $row;
    }
}

echo json_encode($assignments);

mysqli_free_result($result);
mysqli_close($mysqli);
