<?php
session_start();
require_once('config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
if (!isset($_SESSION['admin_id'])) {
    echo "
    <script>
                document.cookie = 'alert = 5;';
                window.location.href='Login';
                </script>";
}


if(isset($_GET['id'])){
    $fetch_schedule_data = $db_handle->runQuery("SELECT * FROM schedule WHERE schedule_id = '".$_GET['id']."'");
}


if(isset($_POST['update_schedule'])){
    $id = $db_handle->checkValue($_POST['id']);
    $session_name = $db_handle->checkValue($_POST['session_name']);
    $session_title = $db_handle->checkValue($_POST['session_title']);
    $host_organization = $db_handle->checkValue($_POST['host_organization']);
    $theme = $db_handle->checkValue($_POST['theme']);
    $venue = $db_handle->checkValue($_POST['venue']);
    $capacity = $db_handle->checkValue($_POST['capacity']);
    $modality = $db_handle->checkValue($_POST['modality']);
    $date = $db_handle->checkValue($_POST['date']);
    $time = $db_handle->checkValue($_POST['time']);
    $description = $db_handle->checkValue($_POST['description']);
    $type = $db_handle->checkValue($_POST['type']);

    $update = $db_handle->insertQuery("UPDATE `schedule` SET `session_name`='$session_name',`host_organization`='$host_organization',`modality`='$modality',`theme`='$theme',`description`='$description',`capacity`='$capacity',`date`='$date',`time`='$time',`title`='$session_title',`venue`='$venue',`status`='$type',`updated_at`='$inserted_at' WHERE `schedule_id` = '$id'");
    if($update){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Schedule';
                </script>";
    } else{
        echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href = 'Schedule';
                </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>User Details - Toilet Conference</title>
    <?php include('include/css.php'); ?>

</head>
<body>

<!--*******************
    Preloader start
********************-->
<?php include('include/preloader.php'); ?>
<!--*******************
    Preloader end
********************-->

<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <?php include('include/header_logo.php'); ?>
    <!--**********************************
        Nav header end
    ***********************************-->


    <!--**********************************
        Header start
    ***********************************-->
    <?php include('include/header.php'); ?>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <?php include('include/menu.php'); ?>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit schedule</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit schedule</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card profile-card">
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <input type="hidden" value="<?php echo $_GET['id']?>" name="id"/>
                                                <div class="basic-form">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="session_name" placeholder="Session Name/Number" value="<?php echo $fetch_schedule_data[0]['session_name'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="session_title" placeholder="Session Title" value="<?php echo $fetch_schedule_data[0]['title'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="host_organization" placeholder="Host Organization" value="<?php echo $fetch_schedule_data[0]['host_organization'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="theme" placeholder="Theme" value="<?php echo $fetch_schedule_data[0]['theme'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="venue" placeholder="Venue" value="<?php echo $fetch_schedule_data[0]['venue'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="capacity" placeholder="Capacity" value="<?php echo $fetch_schedule_data[0]['capacity'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="modality" placeholder="Modality" value="<?php echo $fetch_schedule_data[0]['modality'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="date" placeholder="Date" value="<?php echo $fetch_schedule_data[0]['date'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control input-rounded" name="time" placeholder="Time" value="<?php echo $fetch_schedule_data[0]['time'];?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="4" id="comment" name="description">value="<?php echo $fetch_schedule_data[0]['description'];?>"</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control form-control-lg default-select" name="type">
                                                            <option>Select Type</option>
                                                            <option value="0" <?php if($fetch_schedule_data[0]['status'] == 0) echo 'selected';?>>Private</option>
                                                            <option value="1" <?php if($fetch_schedule_data[0]['status'] == 1) echo 'selected';?>>Public</option>
                                                            <option value="2" <?php if($fetch_schedule_data[0]['status'] == 2) echo 'selected';?>>Avail</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" name="update_schedule" class="btn btn-primary">Update Schedule</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->

    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Powered By © FrogBID</p>
        </div>
    </div>
    <!--**********************************
        Footer end
    ***********************************-->

    <!--**********************************
       Support ticket button start
    ***********************************-->

    <!--**********************************
       Support ticket button end
    ***********************************-->


</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<?php include('include/js.php'); ?>
</body>

</html>