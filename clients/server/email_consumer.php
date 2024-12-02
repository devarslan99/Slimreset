<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Predis\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$redis = new Client();

while (true) {
    $job = $redis->lpop('email_alert_queue');

    if ($job) {
        $jobData = json_decode($job, true);

        $email = $jobData['email'];
        $message = $jobData['message'];
        $sender_name = $jobData['sender_name'];

        sendOtpEmail($email, $message, $sender_name);
    } else {
        echo "No jobs in queue. Sleeping...\n";
        sleep(5);
    }
}

function sendOtpEmail($email, $message, $sender_name)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'support@carepartnershc.com';
        $mail->Password = 'Care_Partners_123';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('support@carepartnershc.com', 'EXAKEY');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'A new message arrived';
        $mail->Body = "Hello, <strong>$sender_name</strong> has sent you the following message:<br><br>" . htmlspecialchars($message);
        $mail->AltBody = "Hello, $sender_name has sent you the following message: $message";

        $mail->send();
        echo "Email sent to: $email\n";
    } catch (Exception $e) {
        echo "Failed to send email: {$mail->ErrorInfo}\n";
    }
}
