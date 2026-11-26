<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

if(isset($_SESSION['user_id'])){
    $code = $db_handle->checkValue($_POST['registrationPromo']);
    $code_verification_no = $db_handle->numRows("SELECT * FROM `promo_code` WHERE code='$code' and status = 0");
    $code_verification = $db_handle->runQuery("SELECT * FROM `promo_code` WHERE code='$code' and status = 0");
    if($code_verification_no == 1){
        $update_code = $db_handle->insertQuery("UPDATE `promo_code` SET `status`='1' WHERE code='$code'");
        if($update_code){
            echo json_encode([
                "status" => "Success",
                "value" => $code_verification[0]['discount']
            ]);
        }
    } else{
        echo "Something Went Wrong";
        exit();
    }
}else {
    echo "Please Login First";
}