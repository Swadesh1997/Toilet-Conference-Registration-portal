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

if (!isset($data['session_type'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Session Type is required!'
    ]);
    exit;
}

// Sanitize input (you can expand or improve this depending on your use case)
$session_type = $db_handle->checkValue($data['session_type']);

if($session_type==1){
    // Query to fetch schedule data from the `schedule` table
    $query = "SELECT * FROM schedule where status=2 or status='$session_type'";
}else{
    $query = "SELECT * FROM schedule";
}

$fetch_schedule = $db_handle->runQuery($query);
$fetch_schedule_count = $db_handle->numRows($query);

if ($fetch_schedule_count > 0) {
    
    // Iterate through the fetched schedules to calculate capacityHold
    foreach ($fetch_schedule as &$schedule) {
        $scheduleId = $schedule['schedule_id']; // Get the schedule_id
        
        // Get the number of "in" scans
        $query = "SELECT * FROM `attendent` WHERE schedule_type='in' AND schedule_id='$scheduleId'";
        $inNum = $db_handle->numRows($query);
        
        // Get the number of "out" scans
        $query = "SELECT * FROM `attendent` WHERE schedule_type='out' AND schedule_id='$scheduleId'";
        $outNum = $db_handle->numRows($query);
        
        $query = "SELECT * FROM `attendent` WHERE schedule_type='availed' AND schedule_id='$scheduleId'";
        $availedNum = $db_handle->numRows($query);
        
        // Calculate capacityHold
        $capacityHold = $inNum + $availedNum - $outNum;
        
        // Add the capacityHold value to the schedule data
        $schedule['capacityHold'] = $capacityHold;
    }
    
    // Return schedule data if found
    echo json_encode([
        'status' => 'success',
        'message' => 'Schedule data fetched successfully',
        'schedule' => $fetch_schedule
    ]);
} else {
    // No schedule data found
    echo json_encode([
        'status' => 'error',
        'message' => 'No schedule data found.'
    ]);
}
?>
