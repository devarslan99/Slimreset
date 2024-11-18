<?php
include_once '../../database/db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $loginUserRole = mysqli_real_escape_string($mysqli, $_POST['loginUserRole'] ?? '');
    $weight = mysqli_real_escape_string($mysqli, $_POST['weight']);
    $selected_date = mysqli_real_escape_string($mysqli, $_POST['selected_date']);
    $user_id = ($loginUserRole === 'coach') ? mysqli_real_escape_string($mysqli, $_POST['userId']) : $_SESSION['user_id'];

    if (!$weight || !$selected_date || !$user_id) {
        echo "Invalid Input";
        exit;
    }

    // Check if the record for the selected date and user already exists
    $check_query = "SELECT 1 FROM weight_records WHERE DATE(created_at) = '$selected_date' AND user_id = '$user_id'";
    $result = mysqli_query($mysqli, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Update existing weight record
        $update_query = "UPDATE weight_records SET weight='$weight' WHERE DATE(created_at) = '$selected_date' AND user_id = '$user_id'";
        echo mysqli_query($mysqli, $update_query) ? "Success" : "Failed to Update";
    } else {
        // Insert new weight record
        $insert_query = "INSERT INTO weight_records (user_id, weight, created_at) VALUES ('$user_id', '$weight', '$selected_date')";
        echo mysqli_query($mysqli, $insert_query) ? "Success" : "Error";
    }

    mysqli_close($mysqli); // Close the database connection
} else {
    echo "Invalid Method";
}
