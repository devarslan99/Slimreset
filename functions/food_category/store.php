<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values and sanitize
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);

    // Check if the category name is unique
    $category_check_query = "SELECT * FROM food_category WHERE name='$name' LIMIT 1";
    $result = mysqli_query($mysqli, $category_check_query);
    $category = mysqli_fetch_assoc($result);

    if ($category) {
        echo "Category name is already in use";
    } else {
        // Insert the new food category into the database
        $sql = "INSERT INTO food_category (name, description) 
                VALUES ('$name', '$description')";

        if (mysqli_query($mysqli, $sql)) {
            echo "Success";
        } else {
            echo "Error while submitting data";
        }
    }

    // Close the database connection
    mysqli_close($mysqli);
} else {
    echo "Form submission method is not POST.";
}
