<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {
        $first_name = mysqli_real_escape_string($mysqli, $_POST['first_nanme']);
        $last_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email_address']);
        $address = mysqli_real_escape_string($mysqli, $_POST['address']);
        $city = mysqli_real_escape_string($mysqli, $_POST['city']);
        $postal_code = mysqli_real_escape_string($mysqli, $_POST['postal_code']);
        $contact_no = mysqli_real_escape_string($mysqli, $_POST['contact_number']);
        $role = mysqli_real_escape_string($mysqli, $_POST['role']);
        $user_id = mysqli_real_escape_string($mysqli, $_POST['user_id']);

        $email_check_query = "SELECT * FROM users WHERE email='$email' AND id != '$user_id'LIMIT 1";
        $result = mysqli_query($mysqli, $email_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            echo "Email is already in use By another user";
        } else {
            $sql = "UPDATE users SET first_name = '$first_nanme',last_name = '$last_name', email = '$email',role= '$role', address = '$address', city= '$city', postal_code = '$postal_code', contact_no = '$contact_no' WHERE id = '$user_id'";   
            if (mysqli_query($mysqli, $sql)) {
                echo "Success";
            } else {
                echo "Error while submitting data";
            }
        }    
        mysqli_close($mysqli);
    } else {
        echo "Please Fill All The Fields";
    }
} else {
    echo "Form submission method is not POST.";
}
?>
