<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); // Ensure response is JSON
header("Cache-Control: no-cache, no-store, must-revalidate"); // Avoid caching of preflight requests
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");

// Handle preflight requests (OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get JSON input from the request body
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['volunteer_id']) || !isset($data['hall_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Volunteerd are required!'
    ]);
    exit;
}

// Sanitize input (you can expand or improve this depending on your use case)
$volunteer_id = $db_handle->checkValue($data['volunteer_id']);
$hall_id = $db_handle->checkValue($data['hall_id']);

// Query to check if the user exists with the given email
$query = "SELECT * FROM user_status WHERE hall_id='$hall_id' and status=1";
$fetch_user = $db_handle->runQuery($query);
$fetch_user_no = $db_handle->numRows($query);

if ($fetch_user_no != 1) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found! Please check your email and try again.'
    ]);
    exit;
}

// Fetch user details
$user = $fetch_user[0];

if ($fetch_user) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Fetch Successful',
        'inNow' => $fetch_user_no
    ]);
    exit;
}

