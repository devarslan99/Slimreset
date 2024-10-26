<?php
include_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['category_id'])) {
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $category_id = mysqli_real_escape_string($mysqli, $_POST['category_id']);
        $food_item_id = mysqli_real_escape_string($mysqli, $_POST['food_item_id']);

        $email_check_query = "SELECT * FROM food_items WHERE name='$name' AND id != '$food_item_id'LIMIT 1";
        $result = mysqli_query($mysqli, $email_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            echo "Food Item Name is Already in Use.";
        } else {
            $sql = "UPDATE food_items SET name = '$name', category_id = '$category_id' WHERE id = '$food_item_id'";   
            if (mysqli_query($mysqli, $sql)) {
                echo "Success";
            } else {
                echo "Error while submitting data";
            }
        }    
        mysqli_close($mysqli);
    } else {
        echo "Please Fill All The Fields";
    }
} else {
    echo "Form submission method is not POST.";
}
?>
