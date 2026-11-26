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

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email and password are required!'
    ]);
    exit;
}

// Sanitize input (you can expand or improve this depending on your use case)
$email = $db_handle->checkValue($data['email']);
$password = $db_handle->checkValue($data['password']);

// Query to check if the user exists with the given email
$query = "SELECT * FROM admin_login, halls WHERE halls.hall_id=admin_login.allocated_hall and admin_login.admin_email='$email'";
$fetch_user = $db_handle->runQuery($query);
$fetch_user_no = $db_handle->numRows($query);

if ($fetch_user_no != 1) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not found! Please check your email and try again.'
    ]);
    exit;
}
if($fetch_user[0]['email_status'] == '0'){
    echo json_encode([
        'status' => 'error',
        'message' => 'Account is not verified yet. Please check your email and try again.'
    ]);
    exit;
}

// Fetch user details
$user = $fetch_user[0];
$hashed_password = $user['admin_password'];


if (password_verify($password, $hashed_password)) {
    $_SESSION['admin_id'] = $user['admin_id'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Login Successful',
        'admin_id' => $user['admin_id'],  // Pass user id or any relevant information
        'admin_name' => $user['admin_name'],
        'admin_email' => $user['admin_email'],
        'allocated_hall' => $user['allocated_hall'],
        'hall_name' => $user['hall_name'],
        'capacity' => $user['capacity'],
        'token' => generateToken($user['admin_id'])
    ]);
    exit;
} else {
    // Invalid password
    echo json_encode([
        'status' => 'error',
        'message' => 'Incorrect password. Please try again.'
    ]);
    exit;
}

function generateToken($userId) {
    return base64_encode("user_".$userId."_token");
}
