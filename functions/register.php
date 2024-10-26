<?php
include_once "../database/db_connection.php";
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$client_id = $_POST['client_id'];
// Section 2 - Personal Information
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email_address = $_POST['email_address'];
$phone_number = $_POST['phone_number'];
$birth_date = $_POST['birth_date'];
$gender = $_POST['gender'];


// Shipping Address
$address_type = $_POST['address_type'];
$address = $_POST['address'];
$unit_number = $_POST['unit_number'];
$city = $_POST['city'];
$province = $_POST['province'];
$postal_code = $_POST['postal_code'];
$delivery_notes = $_POST['delivery_notes'];


// Medically Prescribed Products
$injections_or_cream = $_POST['injections_or_cream'];

// Weight Data
$today_weight = $_POST['today_weight'];
$goal_weight = $_POST['goal_weight'];
$height_in_feet = $_POST['height_in_feet'];
$height_in_inches = $_POST['height_in_inches'];
$struggled_with_weight = $_POST['struggled_with_weight'];
$methods_tried = $_POST['methods_tried'];
$biggest_struggle_with_weight_loss = $_POST['biggest_struggle_with_weight_loss'];
$course_time = $_POST['course_time'];

// Prescribed Medication
$any_prescribed_medicine = $_POST['any_prescribed_medicine'];
$prescribed_medicine_name = $_POST['prescribed_medicine_name'];
$prescribed_medicine_frequency = isset($_POST['prescribed_medicine_frequency']) ? $_POST['prescribed_medicine_frequency'] : NULL;
$prescribed_medicine_dose = $_POST['prescribed_medicine_dose'];
$prescribed_medicine_treatment = $_POST['prescribed_medicine_treatment'];

// Over the Counter Medication
$any_counter_medicine = $_POST['any_counter_medicine'];
$counter_medicine_name = $_POST['counter_medicine_name'];
$counter_medicine_frequency = isset($_POST['counter_medicine_frequency']) ? $_POST['counter_medicine_frequency'] : NULL;
$counter_medicine_dose = $_POST['counter_medicine_dose'];
$counter_medicine_treatment = $_POST['counter_medicine_treatment'];

// Supplements
$any_supplement_medicine = $_POST['any_supplement_medicine'];
$supplement_medicine_name = $_POST['supplement_medicine_name'];
$supplement_medicine_frequency = isset($_POST['supplement_medicine_frequency']) ? $_POST['supplement_medicine_frequency'] : NULL;
$supplement_medicine_dose = $_POST['supplement_medicine_dose'];
$supplement_medicine_treatment = $_POST['supplement_medicine_treatment'];

// Product Consumption
$smoke_tobacco = $_POST['smoke_tobacco'];
$how_many_packs = $_POST['how_many_packs'];
$drink_alcohol = $_POST['drink_alcohol'];
$how_many_drinks = $_POST['how_many_drinks'];
$have_caffeine = $_POST['have_caffeine'];
$how_many_cups_of_coffee = $_POST['how_many_cups_of_coffee'];

// Conditions (Heart Disease, High Blood Pressure, etc.)
$condition_1 = $_POST['condition_1'];
$condition_2 = $_POST['condition_2'];
$condition_3 = $_POST['condition_3'];

// Past Medical Condition
$past_condition_not_covered = $_POST['past_condition_not_covered'];
$past_uncovered_condition = $_POST['past_uncovered_condition'];
$past_condition_inherited = isset($_POST['past_condition_inherited']) ? $_POST['past_condition_inherited'] : NULL;
$past_condition_cause = $_POST['past_condition_cause'];
$past_condition_solution = $_POST['past_condition_solution'];

// Present Medical Condition
$present_condition_not_covered = $_POST['present_condition_not_covered'];
$present_uncovered_condition = $_POST['present_uncovered_condition'];
$present_condition_inherited = isset($_POST['present_condition_inherited']) ? $_POST['present_condition_inherited'] : NULL;
$present_condition_cause = $_POST['present_condition_cause'];
$present_condition_solution = $_POST['present_condition_solution'];

// Symptoms
$symptoms_value = $_POST['symptoms_value'];
$doctor_aware = $_POST['doctor_aware'];
$when_started = $_POST['when_started'];
$anything_done = $_POST['anything_done'];

// Women Only Symptoms
$women_doctor_aware = $_POST['women_doctor_aware'];
$women_anything_done = $_POST['women_anything_done'];

// Program Terms & Acknowledgment
$hormone_therapy = isset($_POST['hormone_therapy']) ? 'Yes' : 'No';
$hormone_medication = isset($_POST['hormone_medication']) ? 'Yes' : 'No';
$primary_care = isset($_POST['primary_care']) ? 'Yes' : 'No';
$symptoms_acknowledge = isset($_POST['symptoms_acknowledge']) ? 'Yes' : 'No';
$side_effect_acknowledge = isset($_POST['side_effect_acknowledge']) ? 'Yes' : 'No';
$medical_disclosure = isset($_POST['medical_disclosure']) ? 'Yes' : 'No';
$disclosure_failure = isset($_POST['disclosure_failure']) ? 'Yes' : 'No';
$compliance_1 = isset($_POST['compliance_1']) ? 'Yes' : 'No';
$compliance_2 = isset($_POST['compliance_2']) ? 'Yes' : 'No';
$compliance_3 = isset($_POST['compliance_3']) ? 'Yes' : 'No';
$compliance_4 = isset($_POST['compliance_4']) ? 'Yes' : 'No';
$medical_no_fund = isset($_POST['medical_no_fund']) ? 'Yes' : 'No';
$signature_acknowledge = isset($_POST['signature_acknowledge']) ? 'Yes' : 'No';


// Signature Handling
if (isset($_POST['signature'])) {
    // Decode the base64-encoded signature image
    $signature_base64 = $_POST['signature'];
    $signature = str_replace('data:image/png;base64,', '', $signature_base64);
    $signature = str_replace(' ', '+', $signature);
    $signature_data = base64_decode($signature);

    // Generate a unique file name for the signature image
    $signature_file_name = 'signature_' . time() . '.png';

    // Save the file in the uploads directory
    $file_path = '../uploads/' . $signature_file_name;
    if (file_put_contents($file_path, $signature_data)) {
        // Signature successfully saved
    } else {
        echo "Failed to upload signature.";
        exit;
    }
} else {
    $file_path = ''; // If no signature provided, leave it blank
}


// Check if email already exists in the users table
$email_check_query = "SELECT id FROM users WHERE email = '$email_address'";
$email_check_result = mysqli_query($mysqli, $email_check_query);

if (mysqli_num_rows($email_check_result) > 0) {
    echo "Error: This email address is already registered.";
} else {

    // Generate a random password and hash it
    $generated_password = bin2hex(random_bytes(4));  // 8-character random password
    $hashed_password = password_hash($generated_password, PASSWORD_BCRYPT);

    if ($client_id !== "") {
        $user_insert_query = "INSERT INTO users (first_name, last_name, email, contact_no, birth_date, gender, address_type, address, unit_number, city, province, postal_code, delivery_notes,password,signature,created_by) 
               VALUES ('$first_name', '$last_name', '$email_address', '$phone_number', '$birth_date', '$gender', '$address_type', '$address', '$unit_number', '$city', '$province', '$postal_code', '$delivery_notes','$hashed_password', '$file_path','$client_id')";
    } else {
        $user_insert_query = "INSERT INTO users (first_name, last_name, email, contact_no, birth_date, gender, address_type, address, unit_number, city, province, postal_code, delivery_notes,password,signature) 
               VALUES ('$first_name', '$last_name', '$email_address', '$phone_number', '$birth_date', '$gender', '$address_type', '$address', '$unit_number', '$city', '$province', '$postal_code', '$delivery_notes','$hashed_password', '$file_path')";
    }


    if (mysqli_query($mysqli, $user_insert_query)) {
        // Get the last inserted user_id
        $user_id = mysqli_insert_id($mysqli);

        // Insert the medical intake data
        $medical_insert_query = "INSERT INTO medical_intake (
            user_id, injections_or_cream, goal_weight, height_in_feet,height_in_inches, struggled_with_weight, methods_tried, biggest_struggle_with_weight_loss, 
            any_prescribed_medicine, prescribed_medicine_name, prescribed_medicine_frequency, prescribed_medicine_dose, prescribed_medicine_treatment, 
            any_counter_medicine, counter_medicine_name, counter_medicine_frequency, counter_medicine_dose, counter_medicine_treatment, 
            any_supplement_medicine, supplement_medicine_name, supplement_medicine_frequency, supplement_medicine_dose, supplement_medicine_treatment, 
            smoke_tobacco, how_many_packs, drink_alcohol, how_many_drinks, have_caffeine, how_many_cups_of_coffee, 
            past_condition_not_covered, past_uncovered_condition, past_condition_inherited, past_condition_cause, past_condition_solution, 
            present_condition_not_covered, present_uncovered_condition, present_condition_inherited, present_condition_cause, present_condition_solution,course_time
        ) 
        VALUES (
            '$user_id', '$injections_or_cream','$goal_weight', '$height_in_feet','$height_in_inches', '$struggled_with_weight', '$methods_tried', '$biggest_struggle_with_weight_loss', 
            '$any_prescribed_medicine', '$prescribed_medicine_name', '$prescribed_medicine_frequency', '$prescribed_medicine_dose', '$prescribed_medicine_treatment', 
            '$any_counter_medicine', '$counter_medicine_name', '$counter_medicine_frequency', '$counter_medicine_dose', '$counter_medicine_treatment', 
            '$any_supplement_medicine', '$supplement_medicine_name', '$supplement_medicine_frequency', '$supplement_medicine_dose', '$supplement_medicine_treatment', 
            '$smoke_tobacco', '$how_many_packs', '$drink_alcohol', '$how_many_drinks', '$have_caffeine', '$how_many_cups_of_coffee', 
            '$past_condition_not_covered', '$past_uncovered_condition', '$past_condition_inherited', '$past_condition_cause', '$past_condition_solution', 
            '$present_condition_not_covered', '$present_uncovered_condition', '$present_condition_inherited', '$present_condition_cause', '$present_condition_solution','$course_time'
        )";


        if (mysqli_query($mysqli, $medical_insert_query)) {
            // Insert symptoms into symptoms table
            for ($i = 0; $i <= 8; $i++) {
                if (isset($_POST['symptoms_value'][$i])) {
                    $symptoms_value = $_POST['symptoms_value'][$i];
                    $doctor_aware = $_POST['doctor_aware'][$i];
                    $when_started = $_POST['when_started'][$i];
                    $anything_done = $_POST['anything_done'][$i];

                    $symptoms_insert_query = "INSERT INTO symptoms (user_id, symptom_id, doctor_aware, when_started, anything_done) 
                                              VALUES ('$user_id', '$i', '$doctor_aware', '$when_started', '$anything_done')";
                    mysqli_query($mysqli, $symptoms_insert_query);
                }
            }
            // Insert women's symptoms data
            for ($i = 0; $i <= 8; $i++) {
                if (isset($_POST['women_doctor_aware'][$i]) && !empty($_POST['women_doctor_aware'][$i]) && isset($_POST['women_anything_done'][$i]) && !empty($_POST['women_anything_done'][$i])) {
                    // Ensure the symptom_id and related values are properly defined
                    $women_doctor_aware = $_POST['women_doctor_aware'][$i];
                    $women_anything_done = $_POST['women_anything_done'][$i];

                    // Insert into the women_symptoms table
                    $women_symptoms_insert_query = "INSERT INTO women_symptoms (user_id, symptom_id, doctor_aware, anything_done) 
                                                    VALUES ('$user_id', '$i', '$women_doctor_aware', '$women_anything_done')";
                    mysqli_query($mysqli, $women_symptoms_insert_query);
                }
            }
            // Insert conditions table
            for ($i = 0; $i < 10; $i++) {
                // Get the values for each index
                $cond_1 = $_POST['condition_1'][$i];
                $cond_2 = $_POST['condition_2'][$i];
                $cond_3 = $_POST['condition_3'][$i];


                // Insert into medical_conditions table, including the index ($i + 1 for human-readable index starting from 1)
                $query_medical_conditions = "INSERT INTO medical_conditions (user_id, have_condition, inherited_from, was_before_age, condition_id)
                                             VALUES ('$user_id', '$cond_1', '$cond_2', '$cond_3', '" . ($i + 1) . "')";
                $mysqli->query($query_medical_conditions);
            }


            // Insert into acknowledgement table
            $query_acknowledge = "INSERT INTO acknowledgement (user_id, hormone_therapy, hormone_medication, primary_care, symptoms_acknowledge, side_effect_acknowledge, medical_disclosure, disclosure_failure, compliance_1, compliance_2, compliance_3, compliance_4, medical_no_fund, signature_acknowledge)
            VALUES ('$user_id', '$hormone_therapy', '$hormone_medication', '$primary_care', '$symptoms_acknowledge', '$side_effect_acknowledge', '$medical_disclosure', '$disclosure_failure', '$compliance_1', '$compliance_2', '$compliance_3', '$compliance_4', '$medical_no_fund', '$signature_acknowledge')";
            $mysqli->query($query_acknowledge);

            $current_date = date('Y-m-d');
            $query_weight = "INSERT INTO weight_records (user_id,weight,created_at) VALUES ('$user_id','$today_weight','$current_date')";
            $mysqli->query($query_weight);


            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();                                          // Send using SMTP
                $mail->Host = 'smtp.titan.email';                   // Set the SMTP server to send through
                $mail->SMTPAuth = true;                                  // Enable SMTP authentication
                $mail->Username = 'support@carepartnershc.com';              // SMTP username
                $mail->Password = 'Care_Partners_123';                 // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port = 587;                                   // TCP port to connect to

                //Recipients
                $mail->setFrom('support@carepartnershc.com', 'EXAKEY');
                $mail->addAddress($email_address, "$first_name $last_name");  // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Your Account Details';
                $mail->Body = "Dear $first_name $last_name,<br><br>Your account has been created. Here are your login details:<br><br>
                              <strong>Email:</strong> $email_address<br>
                              <strong>Password:</strong> $generated_password<br><br>
                              Please change your password after logging in.<br><br>Best regards,<br>Your Company";
                $mail->AltBody = "Dear $first_name $last_name,\n\nYour account has been created. Here are your login details:\n\n
                              Email: $email_address\nPassword: $generated_password\n\nPlease change your password after logging in.\n\nBest regards,\nYour Company";

                $mail->send();
                echo 'success';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error inserting medical intake: " . mysqli_error($mysqli);
        }
    } else {
        echo "Error inserting user: " . mysqli_error($mysqli);
    }
}

// Close the connection
mysqli_close($mysqli);
?>