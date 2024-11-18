<?php
include_once '../../database/db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginUserRole = mysqli_real_escape_string($mysqli, $_POST['loginUserRole'] ?? '');
    $user_id = ($loginUserRole === 'coach') ? mysqli_real_escape_string($mysqli, $_POST['userId']) : $_SESSION['user_id'];
    $water = mysqli_real_escape_string($mysqli, $_POST['water']);
    $selected_date = mysqli_real_escape_string($mysqli, $_POST['selected_date']); // Date in 'YYYY-MM-DD'

    // Check if the record for the selected date and user already exists
    $check_query = "SELECT * FROM water_records WHERE DATE(created_at) = '$selected_date' AND user_id = '$user_id' LIMIT 1";
    $result = mysqli_query($mysqli, $check_query);
    $record = mysqli_fetch_assoc($result);

    if ($record) {
        // If the record exists, update the existing water
        $update_query = "UPDATE water_records SET water='$water' WHERE DATE(created_at) = '$selected_date' AND user_id = '$user_id'";
        if (mysqli_query($mysqli, $update_query)) {
            echo "Success";
        } else {
            echo "Failed to Update";
        }
    } else {
        // If the record does not exist, insert a new record
        $insert_query = "INSERT INTO water_records (user_id, water, created_at) VALUES ('$user_id', '$water', '$selected_date')";
        if (mysqli_query($mysqli, $insert_query)) {
            echo "Success";
        } else {
            echo "Error";
        }
    }

    mysqli_close($mysqli); // Close the database connection
} else {
    echo "Invalid Method";
}
