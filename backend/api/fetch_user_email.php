<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


$fetch_primary_email = $db_handle->runQuery("SELECT * FROM users WHERE user_id = '" . $_SESSION['user_id'] . "'");

if($fetch_primary_email){
    echo json_encode([
        "status"=>'success',
        "primaryEmail"=>$fetch_primary_email[0]["email"],
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No active session found"
    ]);
}