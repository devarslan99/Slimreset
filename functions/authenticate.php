<?php
// Include database connection file
include_once '../database/db_connection.php';

// Define variables and initialize with empty values
$email = $password = '';

// Check if email and password are set
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $post_password = $_POST['password'];

    $sql = "SELECT id, email,first_name, password,profile_image,role,contact_no,address,city,postal_code,cover_image,gender FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $email,$first_name, $password,$profile_image,$role,$contact,$address,$city,$postal_code,$coverimage,$gender);

    if ($stmt->num_rows == 1 && $stmt->fetch() && password_verify($post_password, $password)) {
            session_start();
            $profile_image_src = substr($profile_image, 3);
            $cover_image_src = substr($coverimage,3);
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['full_name'] = $first_name;
            $_SESSION['role'] = $role;
            $_SESSION['profile_image'] = $profile_image_src;
            $_SESSION['cover_image'] = $cover_image_src;
            $_SESSION['contact_no'] = $contact;
            $_SESSION['address'] = $address;
            $_SESSION['city'] = $city;
            $_SESSION['gender'] = $gender;
            $_SESSION['postal_code'] = $postal_code;
            echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}

// Close statement and database connection
$stmt->close();
$mysqli->close();
?>
