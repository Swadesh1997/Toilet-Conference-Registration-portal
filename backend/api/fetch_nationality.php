<?php
session_start();
header("Access-Control-Allow-Origin: *");
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


$fetch_nationality = $db_handle->runQuery("SELECT * FROM countries");
$fetch_nationality_no = $db_handle->numRows("SELECT * FROM countries");

// Initialize an empty array to hold the country names
$nationalities = [];

if ($fetch_nationality_no > 0) {
    foreach ($fetch_nationality as $row) {
        $nationalities[] = $row['nationality'];
    }
}

// Return the countries as JSON
header('Content-Type: application/json');
echo json_encode($nationalities);


