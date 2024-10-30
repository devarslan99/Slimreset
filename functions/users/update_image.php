<?php
include_once '../../database/db_connection.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_FILES['profile_image'])) {
        $user_id = $_POST['user_id'];
        $target_directory = "../../uploads/";
        $file_name = uniqid() . '_' . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_directory . $file_name;
        $finalpath = substr($target_file, 3);

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $sql = "UPDATE users SET profile_image = '$target_file' WHERE id = '$user_id'";

            if (mysqli_query($mysqli, $sql)) {
                if($user_id == $_SESSION['user_id']){
                    $_SESSION['profile_image'] = $finalpath;
                    echo "Success";
                }else{
                    echo "Success";
                }
            } else {
                echo "Error while submitting data";
            }

            mysqli_close($mysqli);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Form submission method is not POST.";
}
?>