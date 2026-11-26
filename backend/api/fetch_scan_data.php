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
if (!isset($decoded_data['unique_id'])) {
    echo json_encode(["status" => "error", "message" => "Unique ID is required!"]);
    exit;
}

// Sanitize input
$unique_id = $db_handle->checkValue($decoded_data['unique_id']);
$scanType = $db_handle->checkValue($decoded_data['scanType']);
$scheduleId = $db_handle->checkValue($decoded_data['scheduleId']);
$voulunterId = $db_handle->checkValue($decoded_data['voulunterId']);

$inserted_at=date('Y-m-d H:i:s');


// Query to get user details by matching unique_id
$query = "SELECT td.user_id, td.title, td.first_name, td.surname, td.passport_file, td.student_file 
          FROM ticket_data td 
          JOIN users u ON u.user_id = td.user_id 
          WHERE u.unique_id = '$unique_id'";

$result = $db_handle->runQuery($query);
$numRows = $db_handle->numRows($query);

if ($numRows > 0) {
    $user = $result[0]; // Get the first matched record
    $userID=$user['user_id'];
    
    $private=1;
    
    $query="select * from schedule where schedule_id='$scheduleId'";
    $schedule=$db_handle->runQuery($query);
    $sessionCapacity=$schedule[0]['capacity'];
    
    $private=$schedule[0]['status'];
    
    if($private==0){
         $query="SELECT * FROM `access_table` WHERE user_id='$userID'";
         $accessDataCheck=$db_handle->runQuery($query);
         
         if($scheduleId==1 && $accessDataCheck[0]['status_one']==1){
             $query="SELECT * FROM `attendent` where schedule_type='in' and schedule_id='$scheduleId' and user_id='$userID'";
            $inNum=$db_handle->numRows($query);
            
            
            $query="SELECT * FROM `attendent` where schedule_type='out' and schedule_id='$scheduleId' and user_id='$userID'";
            $outNum=$db_handle->numRows($query);
            
            $query="SELECT * FROM `attendent` where schedule_type='availed' and schedule_id='$scheduleId' and user_id='$userID'";
            $availedNum=$db_handle->numRows($query);
            
            
            $status='';
            
            if ($scanType == 'availed' && $availedNum > 0) {
                $status = "Already Availed";
            } elseif ($scanType == 'in' && $inNum > $outNum) {
                $status = "Already Scanned In";
            } elseif ($scanType == 'out' && $outNum >= $inNum) {
                $status = "Already Scanned Out";
            }else{
                $query="INSERT INTO `attendent`(`schedule_id`, `user_id`, `volunteer_id`, `schedule_type`, `inserted_at`) VALUES ('$scheduleId','$userID','$voulunterId','$scanType','$inserted_at')";
                $insert=$db_handle->insertQuery($query);
                
                $status="Scaned Successful";
            }
            
        
            if($sessionCapacity==($totalIn-$totalOut)){
                $status="Session Full";
            }
            
            
            echo json_encode([
                'status' => 'success',
                'message' => 'User found!',
                'user_id' => $user['user_id'],
                'title' => $user['title'],
                'first_name' => $user['first_name'],
                'surname' => $user['surname'],
                'passport_file' => $user['passport_file'],
                'student_file' => $user['student_file'],
                'sessionStatus' => $status
            ]);
         }else if($scheduleId==2 && $accessDataCheck[0]['status_two']==1){
             $query="SELECT * FROM `attendent` where schedule_type='in' and schedule_id='$scheduleId' and user_id='$userID'";
            $inNum=$db_handle->numRows($query);
            
            
            $query="SELECT * FROM `attendent` where schedule_type='out' and schedule_id='$scheduleId' and user_id='$userID'";
            $outNum=$db_handle->numRows($query);
            
            $query="SELECT * FROM `attendent` where schedule_type='availed' and schedule_id='$scheduleId' and user_id='$userID'";
            $availedNum=$db_handle->numRows($query);
            
            
            $status='';
            
            if ($scanType == 'availed' && $availedNum > 0) {
                $status = "Already Availed";
            } elseif ($scanType == 'in' && $inNum > $outNum) {
                $status = "Already Scanned In";
            } elseif ($scanType == 'out' && $outNum >= $inNum) {
                $status = "Already Scanned Out";
            }else{
                $query="INSERT INTO `attendent`(`schedule_id`, `user_id`, `volunteer_id`, `schedule_type`, `inserted_at`) VALUES ('$scheduleId','$userID','$voulunterId','$scanType','$inserted_at')";
                $insert=$db_handle->insertQuery($query);
                
                $status="Scaned Successful";
            }
            
        
            if($sessionCapacity==($totalIn-$totalOut)){
                $status="Session Full";
            }
            
            
            echo json_encode([
                'status' => 'success',
                'message' => 'User found!',
                'user_id' => $user['user_id'],
                'title' => $user['title'],
                'first_name' => $user['first_name'],
                'surname' => $user['surname'],
                'passport_file' => $user['passport_file'],
                'student_file' => $user['student_file'],
                'sessionStatus' => $status
            ]);
         }else if($scheduleId==2 && $accessDataCheck[0]['status_two']==1){
             $query="SELECT * FROM `attendent` where schedule_type='in' and schedule_id='$scheduleId' and user_id='$userID'";
            $inNum=$db_handle->numRows($query);
            
            
            $query="SELECT * FROM `attendent` where schedule_type='out' and schedule_id='$scheduleId' and user_id='$userID'";
            $outNum=$db_handle->numRows($query);
            
            $query="SELECT * FROM `attendent` where schedule_type='availed' and schedule_id='$scheduleId' and user_id='$userID'";
            $availedNum=$db_handle->numRows($query);
            
            
            $status='';
            
            if ($scanType == 'availed' && $availedNum > 0) {
                $status = "Already Availed";
            } elseif ($scanType == 'in' && $inNum > $outNum) {
                $status = "Already Scanned In";
            } elseif ($scanType == 'out' && $outNum >= $inNum) {
                $status = "Already Scanned Out";
            }else{
                $query="INSERT INTO `attendent`(`schedule_id`, `user_id`, `volunteer_id`, `schedule_type`, `inserted_at`) VALUES ('$scheduleId','$userID','$voulunterId','$scanType','$inserted_at')";
                $insert=$db_handle->insertQuery($query);
                
                $status="Scaned Successful";
            }
            
        
            if($sessionCapacity==($totalIn-$totalOut)){
                $status="Session Full";
            }
            
            
            echo json_encode([
                'status' => 'success',
                'message' => 'User found!',
                'user_id' => $user['user_id'],
                'title' => $user['title'],
                'first_name' => $user['first_name'],
                'surname' => $user['surname'],
                'passport_file' => $user['passport_file'],
                'student_file' => $user['student_file'],
                'sessionStatus' => $status
            ]);
         }else if($scheduleId==2 && $accessDataCheck[0]['status_two']==1){
            $query="SELECT * FROM `attendent` where schedule_type='in' and schedule_id='$scheduleId' and user_id='$userID'";
            $inNum=$db_handle->numRows($query);
            
            
            $query="SELECT * FROM `attendent` where schedule_type='out' and schedule_id='$scheduleId' and user_id='$userID'";
            $outNum=$db_handle->numRows($query);
            
            $query="SELECT * FROM `attendent` where schedule_type='availed' and schedule_id='$scheduleId' and user_id='$userID'";
            $availedNum=$db_handle->numRows($query);
            
            
            $status='';
            
            if ($scanType == 'availed' && $availedNum > 0) {
                $status = "Already Availed";
            } elseif ($scanType == 'in' && $inNum > $outNum) {
                $status = "Already Scanned In";
            } elseif ($scanType == 'out' && $outNum >= $inNum) {
                $status = "Already Scanned Out";
            }else{
                $query="INSERT INTO `attendent`(`schedule_id`, `user_id`, `volunteer_id`, `schedule_type`, `inserted_at`) VALUES ('$scheduleId','$userID','$voulunterId','$scanType','$inserted_at')";
                $insert=$db_handle->insertQuery($query);
                
                $status="Scaned Successful";
            }
            
        
            if($sessionCapacity==($totalIn-$totalOut)){
                $status="Session Full";
            }
            
            
            echo json_encode([
                'status' => 'success',
                'message' => 'User found!',
                'user_id' => $user['user_id'],
                'title' => $user['title'],
                'first_name' => $user['first_name'],
                'surname' => $user['surname'],
                'passport_file' => $user['passport_file'],
                'student_file' => $user['student_file'],
                'sessionStatus' => $status
            ]);
         }else{
             echo json_encode([
            'status' => 'success',
            'message' => 'User found!',
            'user_id' => $user['user_id'],
            'title' => $user['title'],
            'first_name' => $user['first_name'],
            'surname' => $user['surname'],
            'passport_file' => $user['passport_file'],
            'student_file' => $user['student_file'],
            'sessionStatus' => 'Not Eligible'
        ]);
         }
        
    }else{
        $query="SELECT * FROM `attendent` where schedule_type='in' and schedule_id='$scheduleId' and user_id='$userID'";
        $inNum=$db_handle->numRows($query);
        
        
        $query="SELECT * FROM `attendent` where schedule_type='out' and schedule_id='$scheduleId' and user_id='$userID'";
        $outNum=$db_handle->numRows($query);
        
        $query="SELECT * FROM `attendent` where schedule_type='availed' and schedule_id='$scheduleId' and user_id='$userID'";
        $availedNum=$db_handle->numRows($query);
        
        
        $status='';
        
        if ($scanType == 'availed' && $availedNum > 0) {
            $status = "Already Availed";
        } elseif ($scanType == 'in' && $inNum > $outNum) {
            $status = "Already Scanned In";
        } elseif ($scanType == 'out' && $outNum >= $inNum) {
            $status = "Already Scanned Out";
        }else{
            $query="INSERT INTO `attendent`(`schedule_id`, `user_id`, `volunteer_id`, `schedule_type`, `inserted_at`) VALUES ('$scheduleId','$userID','$voulunterId','$scanType','$inserted_at')";
            $insert=$db_handle->insertQuery($query);
            
            $status="Scaned Successful";
        }
        
    
        if($sessionCapacity==($totalIn-$totalOut)){
            $status="Session Full";
        }
        
        
        echo json_encode([
            'status' => 'success',
            'message' => 'User found!',
            'user_id' => $user['user_id'],
            'title' => $user['title'],
            'first_name' => $user['first_name'],
            'surname' => $user['surname'],
            'passport_file' => $user['passport_file'],
            'student_file' => $user['student_file'],
            'sessionStatus' => $status
        ]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No user found for the given Unique ID!"]);
}
?>
