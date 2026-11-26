<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer();

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

$email = $db_handle->checkValue($_POST['email']);

$get_email = $db_handle->runQuery("SELECT * FROM users WHERE email = '$email'");

$verification_code = 'https://regtoiletconference.org/verify/update_password.php?user=' . $get_email[0]['unique_id'];
$email_to = $email;
$mail->isSMTP();
$mail->Host = env('SMTP_HOST');  // Specify your SMTP server
$mail->SMTPAuth = true;
$mail->Username = env('SMTP_USERNAME');
$mail->Password = env('SMTP_PASSWORD');
$mail->Port = (int) env('SMTP_PORT', 465);
$mail->SMTPSecure = 'ssl';

// Email content
$mail->setFrom(env('MAIL_FROM_ADDRESS'), 'Toilet Conference - Reset Password');
$mail->addAddress($email_to);
$mail->Subject = 'Verify your email.';
$mail->isHTML(true);
$mail->Body = "
            <html>
                <body style='background-color: #eee; font-size: 16px;'>
                <div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>
                
                    <p style='text-align: center;color:green;font-weight:bold'>Thank you for reaching out to us!</p>
                
                    <p style='color:black;text-align: center'>
                        Please visit this link to reset your password.<a href='$verification_code'><strong>Link</strong></a>
                    </p>
                </div>
                </body>
            </html>";

// Send the email
if ($mail->send()) {
    echo json_encode([
        "status" => "success",
        "message" => "Email Send Successfully!"
    ]);
    exit;
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Email is not send."
    ]);
}