<?php
include_once "../../database/db_connection.php";

if (isset($_POST['id'])) {
    $user_id = $_POST['id'];
    $delete_medical_intake_sql = "DELETE FROM medical_intake WHERE user_id = '$user_id'";

    if (mysqli_query($mysqli, $delete_medical_intake_sql)) {
        $delete_selected_food_items_sql = "DELETE FROM selected_food_items WHERE user_id = '$user_id'";
        if (mysqli_query($mysqli, $delete_selected_food_items_sql)) {
            $delete_symptoms_table_sql = "DELETE FROM symptoms WHERE user_id = '$user_id'";
            if (mysqli_query($mysqli, $delete_symptoms_table_sql)) {
                $delete_women_symptom_sql = "DELETE FROM women_symptoms WHERE user_id = '$user_id'";
                if (mysqli_query($mysqli, $delete_women_symptom_sql)) {
                    $delete_user_sql = "DELETE FROM users WHERE id = '$user_id'";
                    if (mysqli_query($mysqli, $delete_user_sql)) {
                        echo "Success";
                    } else {
                        echo "Failed to Delete User";
                    }
                } else {
                    echo "Failed to Delete From Women Symptoms Table";
                }
            } else {
                echo "Failed to Delete From Symptoms Table";
            }
        } else {
            echo "Error Deleting From Food Items Table";
        }
    } else {
        echo "Error Deleting From Medical Intake";
    }
}
?>