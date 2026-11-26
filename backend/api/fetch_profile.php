<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

// If using sessions
if (isset($_SESSION['user_id'])) {
    $fetch_data = $db_handle->runQuery("SELECT * FROM `users`, `ticket_data` WHERE ticket_data.user_id = users.user_id and ticket_data.user_id = '" . $_SESSION['user_id'] . "'");
    echo json_encode([
        "status" => "success",
        "user_id" => $_SESSION['user_id'],
        "title" => $fetch_data[0]['title'],
        "firstName" => $fetch_data[0]['first_name'],
        "surname" => $fetch_data[0]['surname'],
        "email" => $fetch_data[0]['email'],
        "phone" => $fetch_data[0]['phone'],
        "country" => $fetch_data[0]['city'],
        "nationality" => $fetch_data[0]['nationality'],
        "gender" => $fetch_data[0]['gender'],
        "birthYear" => $fetch_data[0]['birth_year'],
        "student" => $fetch_data[0]['student'],
        "organization" => $fetch_data[0]['organization'],
        "designation" => $fetch_data[0]['designation'],
        "visaInvitation" => $fetch_data[0]['visa_invitation'],
        "passportNo" => $fetch_data[0]['passport_no'],
        "issueDate" => $fetch_data[0]['issue_date'],
        "expireDate" => $fetch_data[0]['expire_date'],
        "passportFile" => $fetch_data[0]['passport_file'],
        "dietary" => $fetch_data[0]['dietary'],
        "accessibility" => $fetch_data[0]['accessibility'],
        "language" => $fetch_data[0]['language'],
        "tours" => $fetch_data[0]['tours'],
        "updateDate" => $fetch_data[0]['updated_at'],
        "uniqueId" => $fetch_data[0]['unique_id'],
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No active session found"
    ]);
}
