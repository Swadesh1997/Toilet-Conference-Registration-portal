<?php
session_start();
header("Access-Control-Allow-Origin: *");

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

$email = $db_handle->checkValue($_POST['email']);
$password = $db_handle->checkValue($_POST['password']);

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

function generateUniqueKey($length = 6) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomCode = '';

    // Generate random part
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= $characters[random_int(0, $charactersLength - 1)];
    }

    // Add high-precision timestamp
    $timestamp = str_replace('.', '', microtime(true));
    $uniqueKey = $randomCode . $timestamp;

    return $uniqueKey;
}

$check_email = $db_handle->numRows("SELECT * FROM users WHERE email='$email'");
if($check_email > 0){
    echo "This email is already registered. Please try another email.";
} else {
    $unique_id = generateUniqueKey();

    $insert_form = $db_handle->insertQuery("INSERT INTO `users`(`email`, `password`, `inserted_at`,`unique_id`) 
    VALUES ('$email','$hashedPassword','$inserted_at','$unique_id')");

    if ($insert_form) {
        $get_unique_id = $db_handle->runQuery("select unique_id from users order by user_id desc limit 1");
        $verification_code = 'https://regtoiletconference.org/verify/index.php?user=' . $get_unique_id[0]['unique_id'];
        
        
        $subject = "Verify your email";
        $messege = "<html>
<body style='background-color: #eee; font-size: 16px;'>
<div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>

    <p style='text-align: center;color:#29a9e1;font-weight:bold'>Thank you for registering your account.</p>

    <p style='color:black;text-align: center'>
        Please visit <a href=$verification_code><strong>this link</strong></a> to verify your email.
    </p>
    <div style='font-size: 14px;'>
        <p style='margin-top: 30px;'>Sincerely,</p>
        <img src='https://regtoiletconference.org/user_invoice/logo.jpg' style='width: 200px; height:auto'/>
        <p style='font-weight: bold;'>Conference Secretariat</p>
        <p>House 97/B, Road 25, Block A, Banani, Dhaka 1213, Bangladesh</p>
        <p>c. +880 178 766 5416 c. +880 178 766 5417 t. +880 2 58815757</p>
        <p><a href='mailto:info@toiletconference.org'>info@toiletconference.org</a> | <a href='mailto:www.toiletconference.org'>www.toiletconference.org</a>
        </p>
    </div>

</div>

</body>
</html>";
            
        $sender_name = "Toilet Conference Email Verification";


        $sender_email = env('MAIL_FROM_ADDRESS');
        $username = env('SMTP_USERNAME');
        $password = env('SMTP_PASSWORD');

        $receiver_email = $email;



        $mail = new PHPMailer(true);
        $mail->isSMTP();


        $mail->Host = env('SMTP_HOST');


        $mail->SMTPAuth = true;


        $mail->SMTPSecure = 'ssl';
        $mail->Port = (int) env('SMTP_PORT', 465);

        
        $mail->setFrom($sender_email, $sender_name);
        $mail->Username = $username;
        $mail->Password = $password;
        
        $mail->CharSet = 'UTF-8';
        
        $mail->Subject = $subject;
        $mail->msgHTML($messege);
        $mail->addAddress($receiver_email);
        
        if ($mail->send()) {
           echo json_encode([
                "status" => "success",
                "message" => "Email Send Successfully!"
            ]);
            exit;
        }else{
           echo json_encode([
                "status" => "error",
                "message" => "Email is not send."
            ]);
            exit;
        }
    } else {
        echo "Sorry! Something went wrong. Please try again later.";
    }
}
