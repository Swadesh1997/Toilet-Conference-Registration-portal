<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


$register_status = $db_handle->runQuery("select ticket_data_id from ticket_data where user_id = {$_SESSION['user_id']} and status = 1");
$register_status_no = $db_handle->numRows("select ticket_data_id from ticket_data where user_id = {$_SESSION['user_id']} and status = 1");

if($register_status_no == 1){
    $fetch_invoice_data = $db_handle->numRows("select invoice_id from invoice_data where user_id = {$_SESSION['user_id']}");
    if($fetch_invoice_data == 1){
        echo json_encode([
            "status" => "Success",
        ]);
    } else{
        echo json_encode([
            "status" => "Something went wrong",
        ]);
    }
} else {
    echo json_encode([
        "status" => "Something went wrong",
    ]);
}