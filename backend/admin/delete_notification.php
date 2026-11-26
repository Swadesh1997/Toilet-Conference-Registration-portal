<?php
session_start();
require_once('config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

if(!isset($_GET['noti_id'])){
    echo "<script>
document.cookie = 'alert = 4;';
window.location.href='Notification';
</script>";
}

$delete_noti = $db_handle->insertQuery("DELETE FROM notifications WHERE notification_id = {$_GET['noti_id']}");
if($delete_noti){
    echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Notification';
                </script>";
} else {
    echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href = 'Notification';
                </script>";
}