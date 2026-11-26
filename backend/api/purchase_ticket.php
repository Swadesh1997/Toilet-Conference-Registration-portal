<?php
session_start();
header("Access-Control-Allow-Origin: *");
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

if(isset($_SESSION['user_id'])){
    $flag = $db_handle->checkValue($_POST['flag']);

    if($flag == 1){
        $phone = $db_handle->checkValue($_POST['phone']);
        $city = $db_handle->checkValue($_POST['city']);
        $nationality = $db_handle->checkValue($_POST['nationality']);
        $gender = $db_handle->checkValue($_POST['gender']);
        $otherInput = $db_handle->checkValue($_POST['otherInput']);
        $birthYear = $db_handle->checkValue($_POST['birthYear']);
        $title = $db_handle->checkValue($_POST['title']);
        $firstName = $db_handle->checkValue($_POST['firstName']);
        $surname = $db_handle->checkValue($_POST['surname']);
        $email = $db_handle->checkValue($_POST['email']);
        $otherTitle = $db_handle->checkValue($_POST['otherTitle']);
        if($gender == 'Other'){
            $gender = $otherInput;
        }
        if($title == 'Other'){
            $title = $otherTitle;
        }

        $check_status = $db_handle->numRows("select * from ticket_data where user_id = {$_SESSION['user_id']}");
        if($check_status > 0){
            $insert_data = $db_handle->insertQuery("update ticket_data set `title`='$title',`first_name`='$firstName',`surname`='$surname',`phone`='$phone',`city`='$city',`nationality`='$nationality',`gender`='$gender',`birth_year`='$birthYear',`official_email` = '$email' where user_id = {$_SESSION['user_id']}");
        } else{
            $insert_data = $db_handle->insertQuery("INSERT INTO `ticket_data`(`title`,`first_name`,`surname`,`user_id`, `phone`, `city`, `nationality`, `gender`, `birth_year`, `inserted_at`,`official_email`) 
VALUES ('$title','$firstName','$surname','{$_SESSION['user_id']}','$phone','$city','$nationality','$gender','$birthYear','$inserted_at','$email')");
        }
        if($insert_data){
            echo "Success";
            exit();
        } else {
            echo "Something Went Wrong";
            exit();
        }
    }

    if($flag == 2){
        $student = $db_handle->checkValue($_POST['student']);
        $institution = $db_handle->checkValue($_POST['institution']);
        $organization = $db_handle->checkValue($_POST['organization']);
        $designation = $db_handle->checkValue($_POST['designation']);
        $image = '';
        if (!empty($_FILES['file']['name'])) {
            $RandomAccountNumber = mt_rand(1, 99999);
            $file_name = $RandomAccountNumber . "_" . $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp  = $_FILES['file']['tmp_name'];

            $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if ($file_type != "jpg" && $file_type != "png" && $file_type != "pdf") {
                $attach_files = '';
                echo "This file format is not accepted";

            }
            move_uploaded_file($file_tmp, "../student/" . $file_name);
            $image = "../student/" . $file_name;
        }

        if($institution == NULL){
            $institution = $organization;
        }

        $update_info = $db_handle->insertQuery("UPDATE `ticket_data` SET `student`='$student',`organization`='$institution',`designation`='$designation',`student_file`='$image',`updated_at`='$inserted_at' WHERE `user_id` = {$_SESSION['user_id']}");
        if($update_info){
            echo "Success";
            exit();
        }else {
            echo "Something Went Wrong";
            exit();
        }
    }


    if($flag == 3){
        $invitation = $db_handle->checkValue($_POST['invitation']);
        $passport = $db_handle->checkValue($_POST['passport']);
        $issueDate = $db_handle->checkValue($_POST['issueDate']);
        $expireDate = $db_handle->checkValue($_POST['expireDate']);
        $image = '';
        if (!empty($_FILES['file']['name'])) {
            $RandomAccountNumber = mt_rand(1, 99999);
            $file_name = $RandomAccountNumber . "_" . $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_tmp  = $_FILES['file']['tmp_name'];

            $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if ($file_type != "jpg" && $file_type != "png" && $file_type != "pdf") {
                $attach_files = '';
                echo "This file format is not accepted";

            }
            move_uploaded_file($file_tmp, "../passport/" . $file_name);
            $image = "../passport/" . $file_name;
        }
        $update_info = $db_handle->insertQuery("UPDATE `ticket_data` SET `visa_invitation`='$invitation',`passport_no`='$passport',`issue_date`='$issueDate',`expire_date`='$expireDate',`passport_file`='$image',`updated_at`='$inserted_at' WHERE `user_id`={$_SESSION['user_id']}");
        if($update_info){
            echo "Success";
            exit();
        }else {
            echo "Something Went Wrong";
            exit();
        }
    }

    if($flag == 4){
        $dietary = $db_handle->checkValue($_POST['dietary']);
        $otherDietary = $db_handle->checkValue($_POST['otherDietary']);
        $accessibility = $db_handle->checkValue($_POST['accessibility']);
        $otherAccessibility = $db_handle->checkValue($_POST['otherAccessibility']);
        $language = $db_handle->checkValue($_POST['language']);
        if($dietary == 'Other'){
            $dietary = $otherDietary;
        }
        if($accessibility == 'Other'){
            $accessibility = $otherAccessibility;
        }
        $update_info = $db_handle->insertQuery("UPDATE `ticket_data` SET `dietary`='$dietary',`accessibility`='$accessibility',`language`='$language',`updated_at`='$inserted_at' WHERE `user_id` = {$_SESSION['user_id']}");
        if($update_info){
            echo "Success";
            exit();
        }else {
            echo "Something Went Wrong";
            exit();
        }
    }

    if($flag == 5){
        $tour = $db_handle->checkValue($_POST['selectedTours']);
        $update_info = $db_handle->insertQuery("UPDATE `ticket_data` SET `tours`='$tour',`updated_at`='$inserted_at' WHERE `user_id` = {$_SESSION['user_id']}");
        if($update_info){
            echo "Success";
            exit();
        }else {
            echo "Something Went Wrong";
            exit();
        }
    }

    if($flag == 6){
        $notification = $db_handle->checkValue($_POST['notification']);
        $update_info = $db_handle->insertQuery("UPDATE `ticket_data` SET `notification`='$notification',`updated_at`='$inserted_at' WHERE `user_id` = {$_SESSION['user_id']}");
        if($update_info){
            echo "Success";
            exit();
        }else {
            echo "Something Went Wrong";
            exit();
        }
    }

} else {
    echo "Please Login First";
}




