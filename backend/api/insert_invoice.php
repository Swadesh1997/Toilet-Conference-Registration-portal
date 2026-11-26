<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

$tourPromo = $db_handle->checkValue($_POST['tourPromo']);
$registrationPromo = $db_handle->checkValue($_POST['registrationPromo']);
$grandTotalUpdate = $db_handle->checkValue($_POST['grandTotalUpdate']);
$nationality = $db_handle->checkValue($_POST['nationality']);
$country = $db_handle->checkValue($_POST['country']);
$isBeforeDate = false;
$discount = $db_handle->checkValue($_POST['discount']);
$tourDiscount = $db_handle->checkValue($_POST['tourDiscount']);
$student = $db_handle->checkValue($_POST['student']);

function generateInvoiceNumber ($db_handle) {
    $invoice_number = random_int(100000, 999999);
    $valid = $db_handle->numRows("select * from invoice_data where invoice_no = '$invoice_number'");
    if($valid > 0){
        generateInvoiceNumber();
    } else{
        return $invoice_number;
        exit();
    }
}

$invoice_number = generateInvoiceNumber($db_handle);

$tourValues = [
    "Tour 1 | Faecal Sludge Treatment Plant at Sakhipur",
    "Tour 2 | Public Toilet and Low Income Community Visit at Dhaka",
    "Tour 3 | A day with sanitation workers at Faridpur",
    "Tour 4 | Omni Processor at Cox’s Bazar",
    "Tour 5 | Faecal Sludge Treatment Plant at Saidpur",
];
$tourPrice = [];
if($country == 'Bangladesh'){
    $tourPrice = [9500, 0, 0, 47000, 36500];
} else{
    $tourPrice = [80, 0, 0, 400, 300];
}


// Fetch the tour data from the database
$fetch_tour_data = $db_handle->runQuery("SELECT tours FROM ticket_data WHERE user_id = {$_SESSION['user_id']}");

// Explode the fetched "tours" string into an array
$resultArray = explode(',', $fetch_tour_data[0]['tours']);

// Initialize arrays for selected items and their prices
$items = [];
$price = [];

if($student == 'Student'){
    if($country == 'Bangladesh'){
        $items[0] = 'Student Registration (Bangladeshi)';
        $price[0] = 5000;
    } else {
        $items[0] = 'Student Registration (Foreigner)';
        $price[0] = 50;
    }
}else{
    if($isBeforeDate){
        if($country == 'Bangladesh'){
            $items[0] = 'Early Bird Registration (Bangladeshi)';
            $price[0] = 12000;
        } else {
            $items[0] = 'Early Bird Registration (Foreigner)';
            $price[0] = 100;
        }
    } else{
        if($country == 'Bangladesh'){
            $items[0] = 'Regular Registration (Bangladeshi)';
            $price[0] = 15000;
        } else {
            $items[0] = 'Regular Registration (Foreigner)';
            $price[0] = 125;
        }
    }
}

// Iterate through the resultArray and check for "true"
foreach ($resultArray as $index => $value) {
    if ($value === "true") {
        // Add corresponding tour name and price to the arrays
        $items[] = $tourValues[$index];
        $price[] = $tourPrice[$index];
    }
}

// Convert both arrays to comma-separated strings
$itemsString = implode(", ", $items);
$priceString = implode(", ", $price);



$check_availibility = $db_handle->numRows("select * from invoice_data where user_id = {$_SESSION['user_id']}");
if($check_availibility >= 1){
    echo json_encode([
        "status" => "Success",
    ]);
} else{
    $insert_invoice = $db_handle->insertQuery("INSERT INTO `invoice_data`(`invoice_no`, `user_id`, `items`, `price`, `registratio_promo`, `tour_promo`, `grand_total`, `inserted_at`,`discount`,`tour_discount`) 
VALUES ('$invoice_number','{$_SESSION['user_id']}','$itemsString','$priceString','$registrationPromo','$tourPromo','$grandTotalUpdate','$inserted_at','$discount','$tourDiscount')");

    if($insert_invoice){
        $update_status = $db_handle->insertQuery("update ticket_data set status=1 where user_id = {$_SESSION['user_id']}");
        echo json_encode([
            "status" => "Success",
        ]);
    } else {
        echo json_encode([
            "status" => "Something went wrong",
        ]);
    }
}
