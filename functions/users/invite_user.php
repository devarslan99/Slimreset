<?php
include_once '../../database/db_connection.php';
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_address = mysqli_real_escape_string($mysqli, $_POST['email_address']);
    $user_id = $_SESSION['user_id'];
    // Check if the email is unique
    $email_check_query = "SELECT * FROM users WHERE email='$email_address' LIMIT 1";
    $result = mysqli_query($mysqli, $email_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo "Email is already in use";
    } else {
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
            $mail->addAddress($email_address, "EXA KEY");  // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Invitation to Slim Reset';
            $mail->Body = "You Have Been Invited to use Slim Reset. Please Register Your Account Through: http://localhost/projects/slim-reset/index.php?id=" . $user_id;
            $mail->AltBody = "";

            $mail->send();
            echo 'Success';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    mysqli_close($mysqli);
} else {
    echo "Form submission method is not POST.";
}
