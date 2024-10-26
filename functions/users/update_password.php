<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);
        $user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";   
        if (mysqli_query($mysqli, $sql)) {
            echo "Success";
        } else {
            echo "Error while submitting data";
        }
        mysqli_close($mysqli);
    } else {
        echo "Please Fill All The Fields";
    }
} else {
    echo "Form submission method is not POST.";
}
?>
