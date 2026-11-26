<?php
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require_once('../../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

echo $_GET['user'];

if(isset($_GET['user'])){
    $fetch_user_info = $db_handle->runQuery("select * from ticket_data where user_id = {$_GET['user']}");

    $fetch_unique_id = $db_handle->runQuery("select unique_id,user_id from users where user_id = {$_GET['user']}");
    $data = $fetch_unique_id[0]['unique_id'];
    $user_email = $db_handle->runQuery("SELECT email,official_email FROM `users`,`ticket_data` WHERE users.user_id = ticket_data.user_id and users.user_id = {$_GET['user']}");
    $subject = "Registration confirmation | Toilet Conference 2025";
    $messege = "<html>
<body style='background-color: #eee; font-size: 16px;'>
<div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>

    <p style='text-align: center;color:#29a9e1;font-weight:bold'>Official Invitation</p>

    <div style='color:black;text-align: left'>
        <p>To whom it may concern</p> 
        <p>Dear {$fetch_user_info[0]['title']} {$fetch_user_info[0]['first_name']} {$fetch_user_info[0]['surname']},</p>
        <p>Thank you for successfully registering for the Toilet Conference 2025. We are thrilled to have you on board at this esteem conference.</p>
        <p>As a confirmation to your successful payment and registration completion, we have provided you the Registration Confirmation. Additionally, 
        we have included you a unique QR code inside the registration confirmation which will be used for multiple purposes throughout the conference. 
        Please download it using the link below and bring a copy of the registration confirmation at the conference.</p>
        <p><a href='https://regtoiletconference.org/user_invoice/confirmation.php?user=$data'>Registration Confirmation </a></p>

        <p>If you have any queries, feel free to contact us at
            <a href='mailto:registration@toiletconference.org'>registration@toiletconference.org</a>. </p>

    </div>
    <div style='font-size: 14px;'>
        <p style='margin-top: 30px;'>Sincerely,</p>
        <img src='https://regtoiletconference.org/assets/img/logo/logo-3.png' style='width: 200px; height:auto'/>

        <p style='font-weight: bold; margin-top: 20px;'>Conference Secretariat</p>
        <p>House 97/B, Road 25, Block A, Banani, Dhaka 1213, Bangladesh</p>
        <p>c. +880 178 766 5416 c. +880 178 766 5417 t. +880 2 58815757</p>
        <p><a href='mailto:info@toiletconference.org'>info@toiletconference.org</a> | <a href='mailto:www.toiletconference.org'>www.toiletconference.org</a>
        </p>
    </div>

</div>

</body>
</html>";
    session_unset();
    session_destroy();
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
                    echo "
        <script>
        window.location.href='https://regtoiletconference.org/Logout';
</script>
        ";
                }
            } else {
                echo "
        <script>
        window.location.href='https://regtoiletconference.org/Logout';
</script>
        ";
            }
        }
    } catch (Exception $e) {
        echo "
        <script>
        window.location.href='https://regtoiletconference.org/Logout';
</script>
        ";
    }
}

else {
    echo "
     <script>
        window.location.href='https://regtoiletconference.org/Logout';
</script>
    ";
}