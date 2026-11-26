<?php
session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include('phpqrcode/qrlib.php');

require_once('config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
if(isset($_SESSION['admin_id'])){
    if(isset($_GET['user'])){
        $update_status = $db_handle->insertQuery("update invoice_data set payment_status = 1, updated_at='$inserted_at' where invoice_id = {$_GET['user']}");

        if($update_status){
            $fetch_user_id = $db_handle->runQuery("select user_id from invoice_data where invoice_id = {$_GET['user']}");
            $user_id = $fetch_user_id[0]["user_id"];

            $fetch_user_info = $db_handle->runQuery("select * from ticket_data where user_id = {$user_id}");

            $fetch_unique_id = $db_handle->runQuery("select unique_id,user_id from users where user_id = {$user_id}");
            $data = $fetch_unique_id[0]['unique_id'];
            $file_name = $data.'.png';
            $file = '../user_invoice/qr/'.$file_name;
            QRcode::png($data, $file, QR_ECLEVEL_L, 10);

            $insert_qr = $db_handle->insertQuery("INSERT INTO `user_qr`(`user_id`, `unique_id`, `file`, `inserted_at`) VALUES ('{$fetch_unique_id[0]['user_id']}','$data','$file_name','$inserted_at')");

            if($insert_qr){
                $user_email = $db_handle->runQuery("SELECT email,official_email FROM `users`,`ticket_data` WHERE users.user_id = ticket_data.user_id and users.user_id = '$user_id'");
                $subject = "Registration confirmation | Toilet Conference 2025";
                $messege = "<html>
<body style='background-color: #eee; font-size: 16px;'>
<div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>

    <p style='text-align: center;color:#29a9e1;font-weight:bold'>Official Invitation</p>

    <div style='color:black;text-align: left'>
        <p>Dear {$fetch_user_info[0]['title']} {$fetch_user_info[0]['first_name']} {$fetch_user_info[0]['surname']},</p>
        <p>Thank you for successfully registering to the Toilet Conference 2025. We are thrilled to have you on board at this esteem conference. </p>
        <p>As a confirmation to your successful payment and registration completion, we have provided you with a QR Code embedded acknowledgment receipt. Confirmation.</p>
        <p>Please  
         <a href='https://regtoiletconference.org/user_invoice/confirmation.php?user=$data'>download the registration confirmation </a>and present it at the registration booth of the conference to collect your personalised conference ID.</p>

        <p>If you have any queries, feel free to contact us at 
            <a href='mailto:registration@toiletconference.org'>registration@toiletconference.org</a>. </p>
            
            <p>We look forward to welcoming you to Toilet Conference 2025!</p>

    </div>
    <div style='font-size: 14px;'>
        <p style='margin-top: 30px;'>Sincerely,</p>
        <img src='https://regtoiletconference.org/assets/img/logo/logo-3.png' style='width: 200px; height:auto'/>

        <p style='font-weight: bold; margin-top: 20px;'>Conference Secretariat</p>
        <p>House 97/B, Road 25, Block A, Banani, Dhaka 1213, Bangladesh</p>
        <p>c. +880 178 766 5416 c. +880 178 766 5417 t. +880 2 58815757</p>
        <p><a href='mailto:info@toiletconference.org'>info@toiletconference.org</a> | <a href='mailto:www.toiletconference.org'>www.toiletconference.org</a>
        </p>
        <p><small>Our workweek is Sunday to Thursday, 09.00 to 17.00 Hrs (GMT+6)</small></p>
    </div>

</div>

</body>
</html>";

                $sender_name = "Toilet Conference Registration Confirmation";
                $sender_email = env('MAIL_FROM_ADDRESS');
                $username = env('SMTP_USERNAME');
                $password = env('SMTP_PASSWORD');

                $receiver_email1 = $user_email[0]['email'];
                $receiver_email2 = $user_email[0]['official_email'];

                $mail = new PHPMailer(true);

                try {
                    // Set mailer to use SMTP
                    $mail->isSMTP();
                    $mail->Host = env('SMTP_HOST');  // SMTP server
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = (int) env('SMTP_PORT', 465);

                    // Sender information
                    $mail->setFrom($sender_email, $sender_name);
                    $mail->Username = $username;
                    $mail->Password = $password;
                    $mail->CharSet = 'UTF-8';

                    // Set email subject and body
                    $mail->Subject = $subject;
                    $mail->msgHTML($messege);  // HTML formatted message

                    // Send to first email address
                    $mail->addAddress($receiver_email1);
                    if ($mail->send()) {
                        if($receiver_email2 != NULL){
                            $mail->clearAddresses(); // Clear the first address
                            $mail->addAddress($receiver_email2);
                            if ($mail->send()) {
                                echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Register-Users';
                </script>";
                                exit;
                            } else {
                                echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='Register-Users';
                </script>";
                                exit;
                            }
                        } else {
                            echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Register-Users';
                </script>";
                        }
                    } else {
                        echo "<script>
            document.cookie = 'alert = 4;';
            window.location.href='Register-Users';
            </script>";
                        exit;
                    }
                } catch (Exception $e) {
                    echo "<script>
        document.cookie = 'alert = 4;';
        window.location.href='Register-Users';
        </script>";
                    exit;
                }
            }
        } else {
            echo "<script>
                document.cookie = 'alert = 4;';
                window.location.href='Register-Users';
                </script>";
        }
}
}


