<?php
session_start();
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

$accountNumber = $db_handle->checkValue($_POST['accountNumber']);
$image = '';
if (!empty($_FILES['file']['name'])) {
    $RandomAccountNumber = mt_rand(1, 99999);
    $file_name = $RandomAccountNumber . "_" . $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp  = $_FILES['file']['tmp_name'];

    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if ($file_type != "jpg" && $file_type != "png" && $file_type != "pdf") {
        $attach_files = '';
        echo "This file format is not accepted";
    }
    move_uploaded_file($file_tmp, "../proof/" . $file_name);
    $image = "proof/" . $file_name;
    $insert_prove = $db_handle->insertQuery("UPDATE `invoice_data` SET `proof`='$image',`account_number`='$accountNumber' WHERE `user_id` = {$_SESSION['user_id']}");
    if($insert_prove){
        echo "Success";
        exit();
    } else {
        echo "Something Went Wrong";
        exit();
    }
}