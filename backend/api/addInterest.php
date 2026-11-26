<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
require_once('../config/dbConfig.php'); // Include your database connection file

$db_handle = new DBController(); // Database connection object

// DEBUG: Log raw request data
$raw_post_data = file_get_contents("php://input");
error_log("RAW POST DATA: " . $raw_post_data);

// Decode JSON input
$decoded_data = json_decode($raw_post_data, true);

// Check if unique_id is provided
if (!isset($decoded_data['schedule_name'])) {
    echo json_encode(["status" => "error", "message" => "Schedule Name is required!"]);
    exit;
}

// Sanitize input
$schedule_name = $db_handle->checkValue($decoded_data['schedule_name']);
$userID = $db_handle->checkValue($decoded_data['userID']);
$interestType = $db_handle->checkValue($decoded_data['interestType']);

$inserted_at=date('Y-m-d H:i:s');


// Query to get user details by matching unique_id
$query = "INSERT INTO `interestData`(`schedule_name`, `user_id`, `type`, `inserted_at`) VALUES ('$schedule_name','$userID','$interestType','$inserted_at')";

$result = $db_handle->insertQuery($query);

if ($result) {
    echo json_encode(["status" => "success", "message" => "Data added"]);
} else {
    echo json_encode(["status" => "error", "message" => "No Schedule found"]);
}
?>
