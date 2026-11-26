<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


$fetch_ticket_data = $db_handle->runQuery("SELECT * FROM `ticket_data` WHERE user_id = " . $_SESSION['user_id']);

if($fetch_ticket_data){
    echo json_encode([
        "status"=>"success",
        "title"=>$fetch_ticket_data[0]["title"],
        "first_name"=>$fetch_ticket_data[0]["first_name"],
        "surname"=>$fetch_ticket_data[0]["surname"],
        "phone"=>$fetch_ticket_data[0]["phone"],
        "city"=>$fetch_ticket_data[0]["city"],
        "nationality"=>$fetch_ticket_data[0]["nationality"],
        "gender"=>$fetch_ticket_data[0]["gender"],
        "birth_year"=>$fetch_ticket_data[0]["birth_year"],
        "student"=>$fetch_ticket_data[0]["student"],
        "organization"=>$fetch_ticket_data[0]["organization"],
        "designation"=>$fetch_ticket_data[0]["designation"],
        "student_file"=>$fetch_ticket_data[0]["student_file"],
        "visa_invitation"=>$fetch_ticket_data[0]["visa_invitation"],
        "passport_no"=>$fetch_ticket_data[0]["passport_no"],
        "issue_date"=>$fetch_ticket_data[0]["issue_date"],
        "expire_date"=>$fetch_ticket_data[0]["expire_date"],
        "passport_file"=>$fetch_ticket_data[0]["passport_file"],
        "dietary"=>$fetch_ticket_data[0]["dietary"],
        "accessibility"=>$fetch_ticket_data[0]["accessibility"],
        "language"=>$fetch_ticket_data[0]["language"],
        "tours"=>$fetch_ticket_data[0]["tours"],
        "notification"=>$fetch_ticket_data[0]["notification"],
        "email"=>$fetch_ticket_data[0]["official_email"],
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No active session found"
    ]);
}