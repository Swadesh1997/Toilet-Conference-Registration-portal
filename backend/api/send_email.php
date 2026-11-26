<?php
session_start();
header("Access-Control-Allow-Origin: *");
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer();
include('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Hong_Kong");
$user_id = 1;
$get_email = $db_handle->runQuery("SELECT * FROM users WHERE user_id = '$user_id'");
$email = $get_email[0]['email'];

$verification_code = 'https://regtoiletconference.org/verify/index.php?user=' . $get_email[0]['unique_id'];
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
