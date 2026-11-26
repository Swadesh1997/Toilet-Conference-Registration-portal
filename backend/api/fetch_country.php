<?php
session_start();
header("Access-Control-Allow-Origin: *");
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


$fetch_countries = $db_handle->runQuery("SELECT * FROM countries");
$fetch_countries_no = $db_handle->numRows("SELECT * FROM countries");

// Initialize an empty array to hold the country names
$countries = [];

if ($fetch_countries_no > 0) {
    // Fetch the rows and store country names in the array
    foreach ($fetch_countries as $row) {
        $countries[] = $row['country_name'];
    }
}

// Return the countries as JSON
header('Content-Type: application/json');
echo json_encode($countries);


