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

if (!isset($data['noti_type'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Noti Type is required!'
    ]);
    exit;
}

// Sanitize input (you can expand or improve this depending on your use case)
$noti_type = $db_handle->checkValue($data['noti_type']);

// Query to fetch notification data from the `notifications` table
$query = "SELECT notification FROM notifications WHERE noti_type = 3 OR noti_type = '$noti_type'";
$notification_data = $db_handle->runQuery($query);
$notification_count = $db_handle->numRows($query);

if ($notification_count > 0) {
    // Return notification data if found
    echo json_encode([
        'status' => 'success',
        'message' => 'Notification data fetched successfully',
        'notification' => $notification_data
    ]);
} else {
    // No notification data found
    echo json_encode([
        'status' => 'error',
        'message' => 'No Notification data found.'
    ]);
}
?>
