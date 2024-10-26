<?php
include_once '../../database/db_connection.php';


$clients_query = "SELECT id, first_name, last_name FROM users WHERE role = 'client' AND status = 'Active'";
$clients_result = mysqli_query($mysqli, $clients_query);
$clients = [];

while ($row = mysqli_fetch_assoc($clients_result)) {
    $clients[] = $row;
}

$coaches_query = "SELECT id, first_name, last_name FROM users WHERE role = 'coach' AND status = 'Active'";
$coaches_result = mysqli_query($mysqli, $coaches_query);
$coaches = [];

while ($row = mysqli_fetch_assoc($coaches_result)) {
    $coaches[] = $row;
}

echo json_encode([
    'clients' => $clients,
    'coaches' => $coaches
]);
