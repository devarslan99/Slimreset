<?php
include_once '../../database/db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Fetch the user ID from session
    $weight = mysqli_real_escape_string($mysqli, $_POST['weight']);
    $selected_date = mysqli_real_escape_string($mysqli, $_POST['selected_date']); // Date in 'YYYY-MM-DD'

    // Check if the record for the selected date and user already exists
    $check_query = "SELECT * FROM weight_records WHERE DATE(created_at) = '$selected_date' AND user_id = '$user_id' LIMIT 1";
    $result = mysqli_query($mysqli, $check_query);
    $record = mysqli_fetch_assoc($result);

    if ($record) {
        // If the record exists, update the existing weight
        $update_query = "UPDATE weight_records SET weight='$weight' WHERE DATE(created_at) = '$selected_date' AND user_id = '$user_id'";
        if (mysqli_query($mysqli, $update_query)) {
            echo "Success";
        } else {
            echo "Failed to Update";
        }
    } else {
        // If the record does not exist, insert a new record
        $insert_query = "INSERT INTO weight_records (user_id, weight, created_at) VALUES ('$user_id', '$weight', '$selected_date')";
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
