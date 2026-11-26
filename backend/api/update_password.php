<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


$password = $db_handle->checkValue($_POST['password']);
$newPassword = $db_handle->checkValue($_POST['newPassword']);
$confirmPassword = $db_handle->checkValue($_POST['confirmPassword']);

$fetch_password = $db_handle->runQuery("SELECT password FROM users WHERE user_id = {$_SESSION['user_id']}");

if(password_verify($password, $fetch_password[0]['password'])){
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updatePassword = $db_handle->insertQuery("update users set password = '{$hashedPassword}' where user_id = {$_SESSION['user_id']}");
    if($updatePassword){
        echo json_encode([
            "status" => "Success",
        ]);
        exit;
    } else {
        echo json_encode([
            "status" => "Error",
        ]);
        exit;
    }
}