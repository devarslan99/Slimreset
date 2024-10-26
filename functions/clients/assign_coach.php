<?php
include_once "../../database/db_connection.php";

if (isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];
    $coach_id = $_POST['coach_id'];
    $delete_medical_intake_sql = "UPDATE users SET created_by = '$coach_id' WHERE id = '$client_id'";

    if (mysqli_query($mysqli, $delete_medical_intake_sql)) {
        echo "Success";
    } else {
        echo "Error Deleting From Medical Intake";
    }
}
?>