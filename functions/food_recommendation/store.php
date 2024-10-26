<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values and sanitize
    $food_category_id = mysqli_real_escape_string($mysqli, $_POST['food_category_id']);
    $food_intolerance = mysqli_real_escape_string($mysqli, $_POST['food_intolerance']);
    $food_item_name = mysqli_real_escape_string($mysqli, $_POST['food_item_name']);
    $protein_level = mysqli_real_escape_string($mysqli, $_POST['protein_level']);

    // Check if the food item already exists for the selected category
    $food_check_query = "SELECT * FROM food_recommendation WHERE food_item_name='$food_item_name' AND food_category_id='$food_category_id' LIMIT 1";
    $result = mysqli_query($mysqli, $food_check_query);
    $food = mysqli_fetch_assoc($result);

    if ($food) {
        echo "Food item already exists in this category";
    } else {
        // Insert the new food recommendation into the database
        $sql = "INSERT INTO food_recommendation (food_category_id, food_intolerance, food_item_name, protein_level) 
                VALUES ('$food_category_id', '$food_intolerance', '$food_item_name', '$protein_level')";

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
?>
