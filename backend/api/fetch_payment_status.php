<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


$payment_status = $db_handle->runQuery("select payment_status from invoice_data where user_id = '" . $_SESSION['user_id'] . "'");
$payment_status_no = $db_handle->numRows("select payment_status from invoice_data where user_id = '" . $_SESSION['user_id'] . "'");

if($payment_status_no == 1){
    echo json_encode([
        "status" => "success",
        "paymentStatus" => $payment_status[0]['payment_status'],
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No active session found"
    ]);
}