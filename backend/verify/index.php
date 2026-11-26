<?php
session_start();
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


if(isset($_GET['user'])){
    $user = $_GET['user'];
    $update_status = $db_handle->insertQuery("UPDATE `users` SET `email_status` = '1' WHERE `unique_id` = '$user'");
} else {
    echo "
    <script>
    alert ('You are may be lost!')
    window.location.href = 'https://regtoiletconference.org/Login';
</script>
    ";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification Successful</title>
    <style>
        /* Resetting margin and padding */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-image: url("congratulation-min.gif");
            background-repeat: no-repeat;
            background-position: center;
        }

        /* Flexbox to center content vertically and horizontally */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }

        /* Responsive image styling */
        .image {
            max-width: 100%;
            height: auto;
        }

        /* Styling for the text */
        .text {
            font-size: 1.5rem;
            margin-top: 20px;
            color: #333;
        }

        /* Responsive text size */
        @media (max-width: 600px) {
            .text {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Image element -->
    <img src="congras.png" alt="Placeholder Image" class="image">

    <!-- Text element -->
    <div class="text">
        <p style="font-weight: bold">Your Email is verified successfully! Please <a href="https://regtoiletconference.org/Login">login</a> now to continue.</p>
    </div>
</div>

</body>
</html>

