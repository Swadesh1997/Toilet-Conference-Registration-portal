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
$query = "SELECT * FROM users WHERE email='$email'";
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
$hashed_password = $user['password'];

// Query to fetch the user's ticket data (assuming there is a tickets table)
$query_ticket_data = "SELECT * FROM ticket_data WHERE user_id = '".$user['user_id']."'";
$fetch_ticket_data = $db_handle->runQuery($query_ticket_data);

// Query to fetch the user's ticket data (assuming there is a tickets table)
$query_invoice_data = "SELECT * FROM invoice_data WHERE user_id = '".$user['user_id']."' and payment_status=1";
$fetch_invoice_data = $db_handle->runQuery($query_invoice_data);

// Check if ticket data exists
if ($fetch_ticket_data) {
    $ticket_data = $fetch_ticket_data;
} else {
    $ticket_data = []; // No ticket data found
}

if ($fetch_invoice_data) {
    $invoice_data = $fetch_invoice_data;
} else {
    $invoice_data = []; // No ticket data found
}

if (password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $user['user_id'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Login Successful',
        'user_id' => $user['user_id'],  // Pass user id or any relevant information
        'unique_id' => $user['unique_id'],
        'email' => $user['email'],
        'token' => generateToken($user['user_id']),  // Call a function to generate a JWT or token here (optional)
        'ticket_data' => $ticket_data , // Include ticket data
        'invoice_data' => $invoice_data 
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
