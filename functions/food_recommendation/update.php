<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        $food_category_id = mysqli_real_escape_string($mysqli, $_POST['food_category_id']);
        $food_intolerance = mysqli_real_escape_string($mysqli, $_POST['food_intolerance']);
        $food_item_name = mysqli_real_escape_string($mysqli, $_POST['food_item_name']);
        $protein_level = mysqli_real_escape_string($mysqli, $_POST['protein_level']);

        // Check if the food item name is unique for other records
        $food_item_check_query = "SELECT * FROM food_recommendation WHERE food_item_name='$food_item_name' AND id != '$id' LIMIT 1";
        $result = mysqli_query($mysqli, $food_item_check_query);
        $existing_food_item = mysqli_fetch_assoc($result);

        if ($existing_food_item) {
            echo "Food item name is already in use by another record.";
        } else {
            $sql = "UPDATE food_recommendation SET 
                        food_category_id = '$food_category_id', 
                        food_intolerance = '$food_intolerance', 
                        food_item_name = '$food_item_name', 
                        protein_level = '$protein_level' 
                    WHERE id = '$id'";

            if (mysqli_query($mysqli, $sql)) {
                echo "Success";
            } else {
                echo "Error while updating data: " . mysqli_error($mysqli);
            }
        }

        mysqli_close($mysqli);
    } else {
        echo "Invalid food recommendation ID.";
    }
} else {
    echo "Form submission method is not POST.";
}
?>
