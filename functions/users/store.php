<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email_address']);
    $address = mysqli_real_escape_string($mysqli, $_POST['address']);
    $city = mysqli_real_escape_string($mysqli, $_POST['city']);
    $postal_code = mysqli_real_escape_string($mysqli, $_POST['postal_code']);
    $contact_no = mysqli_real_escape_string($mysqli, $_POST['contact_number']);
    $role = mysqli_real_escape_string($mysqli, $_POST['role']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email is unique
    $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($mysqli, $email_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo "Email is already in use";
    } else {
        $sql = "INSERT INTO users (first_name, last_name,email, address, city, postal_code, contact_no,role,password) 
                VALUES ('$first_name', '$last_name','$email', '$address', '$city', '$postal_code', '$contact_no','$role','$hashed_password')";

        if (mysqli_query($mysqli, $sql)) {
            echo "Success";
        } else {
            echo "Error while submitting data";
        }
    }

    mysqli_close($mysqli);
} else {
    echo "Form submission method is not POST.";
}
