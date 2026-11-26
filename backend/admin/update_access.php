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

if(isset($_GET['user'])){
    $fetch_details = $db_handle->runQuery("select * from access_table where user_id = '".$_GET['user']."'");
}

if(isset($_POST['update_access'])){
    $user = $_GET['user'];
    $vip = $db_handle->checkValue($_POST['vip']);
    $amber = $db_handle->checkValue($_POST['amber']);
    $sercreteriate = $db_handle->checkValue($_POST['sercreteriate']);
    $turag = $db_handle->checkValue($_POST['turag']);
    $extra_1 = $db_handle->checkValue($_POST['extra_1']);
    $extra_2 = $db_handle->checkValue($_POST['extra_2']);

    $update_access = $db_handle->insertQuery("UPDATE `access_table` SET `status_one`='$vip',`status_two`='$amber',`status_three`='$sercreteriate',`status_four`='$turag',`status_five`='$extra_1',`status_six`='$extra_2' WHERE `user_id` = '$user'");
    if($update_access){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Allow-Access';
                </script>";
    } else{
        echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href = 'Allow-Access';
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
    <title>Update Access - Toilet Conference</title>
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Update Access</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Access</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card profile-card">
                                        <div class="card-body">
                                            <form action="#" method="post">
                                                <div class="modal-body">
                                                    <div class="basic-form">
                                                       <input type="hidden" value="<?php $_GET['user'];?>" name="user"/>
                                                        <div class="form-group">
                                                            <label>VIP premium lounge</label>
                                                            <select class="form-control form-control-lg default-select" name="vip">
                                                                <option>Select Type</option>
                                                                <option value="0" <?php if($fetch_details[0]['status_one'] == 0) echo 'selected';?>>Not Allowed</option>
                                                                <option value="1" <?php if($fetch_details[0]['status_one'] == 1) echo 'selected';?>>Allowed</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Amber dinning room</label>
                                                            <select class="form-control form-control-lg default-select" name="amber">
                                                                <option>Select Type</option>
                                                                <option value="0" <?php if($fetch_details[0]['status_two'] == 0) echo 'selected';?>>Not Allowed</option>
                                                                <option value="1" <?php if($fetch_details[0]['status_two'] == 1) echo 'selected';?>>Allowed</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Conference sercreteriate room</label>
                                                            <select class="form-control form-control-lg default-select" name="sercreteriate">
                                                                <option>Select Type</option>
                                                                <option value="0" <?php if($fetch_details[0]['status_three'] == 0) echo 'selected';?>>Not Allowed</option>
                                                                <option value="1" <?php if($fetch_details[0]['status_three'] == 1) echo 'selected';?>>Allowed</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Turag meeting hall</label>
                                                            <select class="form-control form-control-lg default-select" name="turag">
                                                                <option>Select Type</option>
                                                                <option value="0" <?php if($fetch_details[0]['status_four'] == 0) echo 'selected';?>>Not Allowed</option>
                                                                <option value="1" <?php if($fetch_details[0]['status_four'] == 1) echo 'selected';?>>Allowed</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Extra 1</label>
                                                            <select class="form-control form-control-lg default-select" name="extra_1">
                                                                <option>Select Type</option>
                                                                <option value="0" <?php if($fetch_details[0]['status_five'] == 0) echo 'selected';?>>Not Allowed</option>
                                                                <option value="1" <?php if($fetch_details[0]['status_five'] == 1) echo 'selected';?>>Allowed</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Extra 2</label>
                                                            <select class="form-control form-control-lg default-select" name="extra_2">
                                                                <option>Select Type</option>
                                                                <option value="0" <?php if($fetch_details[0]['status_six'] == 0) echo 'selected';?>>Not Allowed</option>
                                                                <option value="1" <?php if($fetch_details[0]['status_six'] == 1) echo 'selected';?>>Allowed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <button type="submit" name="update_access" class="btn btn-primary">Update Access</button>

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