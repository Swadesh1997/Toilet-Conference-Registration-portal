<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");


if (isset($_SESSION['user_id'])) {
    $fetch_items = $db_handle->runQuery("select items from invoice_data");
    $fetch_items_no = $db_handle->numRows("select items from invoice_data");
    for($i=0; $i < $fetch_items_no; $i++){
        $items = explode(',',$fetch_items[$i]['items']);
        foreach ($items as $item){
            if (preg_match('/Tour (\d+)/', $item, $matches)) {
                $number = $matches[1]; // The first captured group
            }
            if($number == 1)
                $tour1++;
            if ($number == 2)
                $tour2++;
            if ($number == 3)
                $tour3++;
            if ($number == 4)
                $tour4++;
            if ($number == 5)
                $tour5++;
            $number = 0;
        }
    }

    if($fetch_items){
        echo json_encode ([
            "status" => "success",
            "tour1" => $tour1,
            "tour2" => $tour2,
            "tour3" => $tour3,
            "tour4" => $tour4,
            "tour5" => $tour5,
        ]);
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => "No active session found"
    ]);
}