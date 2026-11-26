<?php
session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require_once('config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
if(isset($_SESSION['admin_id'])){
    if(isset($_GET['user'])){
        $user_id = $_GET['user'];
        $fetch_user_info = $db_handle->runQuery("select * from ticket_data where user_id = {$user_id}");
        $user_email = $db_handle->runQuery("SELECT email,official_email FROM `users`,`ticket_data` WHERE users.user_id = ticket_data.user_id and users.user_id = '$user_id'");
        $subject = "Toilet Conference - Visa Invitation";
        $issue_date = date('d F Y', strtotime($fetch_user_info[0]['issue_date']));
        $expire_date = date('d F Y', strtotime($fetch_user_info[0]['expire_date']));
        $messege = "<html>
<body style='background-color: #eee; font-size: 16px;'>
<div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>

    <p style='text-align: center;color:#29a9e1;font-weight:bold'>Official Invitation</p>

    <div style='color:black;text-align: left'>
        <p>To whom it may concern</p>
        <p>On behalf of the Toilet Conference Secretariat, we are pleased to invite </p>
        <p>{$fetch_user_info[0]['title']} {$fetch_user_info[0]['first_name']} {$fetch_user_info[0]['surname']}, to attend the Toilet Conference 2025 in Dhaka, Bangladesh. This conference, with the theme “The Future of Sanitation”,
            is jointly convened by WaterAid, UNICEF, SNV, and ITN-BUET, and will take place on 25–26 February 2025 at the InterContinental Dhaka, 1 Minto Road, Dhaka, Bangladesh.</p>
        <p>{$fetch_user_info[0]['first_name']} is a registered participant of the conference, and their presence will make the conference highly successful. The participant may also choose to
            join Technical Tours organised in conjunction with the event. These tours are scheduled to begin on 24 February and extend till 01 March 2025. General information
            about the conference is available at <a href='https://www.toiletconference.org'>www.toiletconference.org</a>. </p>
        <p>We kindly request your assistance in processing an appropriate visa for [Recipients Name] to facilitate this person’s participation in this important event. All expenses
            related to travel and accommodation will be borne by the participant or their sponsoring organisation.</p>
        <p>First Name: {$fetch_user_info[0]['first_name']}</p>
        <p>Last Name: {$fetch_user_info[0]['surname']}</p>
        <p>Passport number: {$fetch_user_info[0]['passport_no']}</p>
        <p>Passport issue date: $issue_date</p>
        <p>Passport expiry date: $expire_date</p>

        <p>Should you require additional information or have any further queries, please do not hesitate to contact Ms Samia Anwar Rafa at
            <a href='mailto:registration@toiletconference.org'>registration@toiletconference.org</a>. </p>

    </div>
    <div style='font-size: 14px;'>
        <p style='margin-top: 30px;'>Sincerely,</p>
        <img src='https://regtoiletconference.org/user_invoice/img.png' style='width: 200px; height:auto'/>
        <p style='font-weight: bold;'>Hasin Jahan</p>
        <p style='font-weight: bold;'>Chair, Steering Committee</p>
        <p style='font-weight: bold;'>Toilet Conference 2025 <br>and<br>Country Director<br>WaterAid Bangladesh</p>

        <p style='font-weight: bold; margin-top: 20px;'>Conference Secretariat</p>
        <p>House 97/B, Road 25, Block A, Banani, Dhaka 1213, Bangladesh</p>
        <p>c. +880 178 766 5416 c. +880 178 766 5417 t. +880 2 58815757</p>
        <p><a href='mailto:info@toiletconference.org'>info@toiletconference.org</a> | <a href='mailto:www.toiletconference.org'>www.toiletconference.org</a>
        </p>
    </div>

</div>

</body>
</html>";

        $sender_name = "Toilet Conference - Visa Invitation";
        $sender_email = env('MAIL_FROM_ADDRESS');
        $username = env('SMTP_USERNAME');
        $password = env('SMTP_PASSWORD');

        $receiver_email1 = $user_email[0]['email'];
        $receiver_email2 = $user_email[0]['official_email'];

        $mail = new PHPMailer(true);

        try {
            // Set mailer to use SMTP
            $mail->isSMTP();
            $mail->Host = env('SMTP_HOST');
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
                    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Visa-Invitation';
                </script>";
            } else {
                echo "<script>
            document.cookie = 'alert = 5;';
            window.location.href = 'Visa-Invitation';
            </script>";
                exit;
            }
        } catch (Exception $e) {
            echo $e;
            exit;
        }

    } else {
        echo "<script>
document.cookie = 'alert = 5;';
window.location.href = 'Visa-Invitation';
</script>";
    }
}


