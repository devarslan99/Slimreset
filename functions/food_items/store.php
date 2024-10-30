<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $category_id = mysqli_real_escape_string($mysqli, string: $_POST['category_id']);

    // Check if the email is unique
    $email_check_query = "SELECT * FROM food_items WHERE name='$name' LIMIT 1";
    $result = mysqli_query($mysqli, $email_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo "Food Item Name is already in use";
    } else {
        $sql = "INSERT INTO food_items (name,category_id) VALUES ('$name','$category_id')";

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
