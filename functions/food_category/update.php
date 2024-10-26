<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = mysqli_real_escape_string($mysqli, $_POST['id']);
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $description = mysqli_real_escape_string($mysqli, $_POST['description']);

        // Check if the category name is unique for other records
        $category_check_query = "SELECT * FROM food_category WHERE name='$name' AND id != '$id' LIMIT 1";
        $result = mysqli_query($mysqli, $category_check_query);
        $existing_category = mysqli_fetch_assoc($result);

        if ($existing_category) {
            echo "Category name is already in use by another record.";
        } else {
            $sql = "UPDATE food_category SET name = '$name', description = '$description' WHERE id = '$id'";

            if (mysqli_query($mysqli, $sql)) {
                echo "Success";
            } else {
                echo "Error while updating data";
            }
        }
        
        mysqli_close($mysqli);
    } else {
        echo "Invalid category ID.";
    }
} else {
    echo "Form submission method is not POST.";
}
?>
