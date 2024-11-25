<?php
include_once '../../../database/db_connection.php';

$sql = "SELECT * FROM `veggie` WHERE status = 1";
$result = mysqli_query($mysqli, $sql);

$mealTypes = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $mealTypes[] = $row;
    }
}

echo json_encode($mealTypes);

mysqli_free_result($result);
mysqli_close($mysqli);
