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

// Validate input
if (!isset($data['volunteer_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Volunteer ID are required!'
    ]);
    exit;
}

// Sanitize input (you can expand or improve this depending on your use case)
$volunteer_id = $db_handle->checkValue($data['volunteer_id']);

// Query to fetch tasks from the tasks table
$query = "SELECT * FROM `tasks` WHERE volunteer_id = '$volunteer_id'";
$fetch_tasks = $db_handle->runQuery($query);
$fetch_tasks_count = $db_handle->numRows($query);

if ($fetch_tasks_count > 0) {
    // Return tasks if found
    echo json_encode([
        'status' => 'success',
        'message' => 'Tasks fetched successfully',
        'tasks' => $fetch_tasks
    ]);
} else {
    // No tasks found for the given volunteer_id and hall_id
    echo json_encode([
        'status' => 'error',
        'message' => 'No tasks found for the given volunteer ID'
    ]);
}
?>
