<?php
session_start();
require_once('config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
if(!isset($_SESSION['admin_id'])){
    echo "
    <script>
                document.cookie = 'alert = 5;';
                window.location.href='Login';
                </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Attendance Data - Toilet Conference</title>
    <?php include ('include/css.php');?>

</head>
<body>

<!--*******************
    Preloader start
********************-->
<?php include ('include/preloader.php');?>
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
    <?php include ('include/header_logo.php');?>
    <!--**********************************
        Nav header end
    ***********************************-->


    <!--**********************************
        Header start
    ***********************************-->
    <?php include ('include/header.php');?>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <?php include ('include/menu.php');?>
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Attendance Data</a></li>
                </ol>
            </div>
            <div class="row">
                <?php
                $fetch_session = $db_handle->runQuery("SELECT * FROM `schedule`");
                $fetch_session_no = $db_handle->numRows("SELECT * FROM `schedule`");
                for($i=0; $i<$fetch_session_no; $i++){
                    ?>
                    <div class="col-xl-3 col-xxl-6 col-lg-4 col-sm-6">
                        <div class="card border-card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body mr-3">
                                        <h2 class="text-success">
                                            <?php
                                            $attendance = 0;
                                            if($fetch_session[$i]['status'] == '0' || $fetch_session[$i]['status'] == '1'){
                                                $fetch_session_in_date = $db_handle->runQuery("SELECT COUNT(att_id) as in_num FROM `attendent` where schedule_id = {$fetch_session[$i]['schedule_id']} and schedule_type = 'in'");
                                                $in = $fetch_session_in_date[0]['in_num'];
                                                $fetch_session_out_date = $db_handle->runQuery("SELECT COUNT(att_id) as out_num FROM `attendent` where schedule_id = {$fetch_session[$i]['schedule_id']} and schedule_type = 'out'");
                                                $out = $fetch_session_out_date[0]['out_num'];
                                                $attendance = $in - $out;
                                            }

                                            if($fetch_session[$i]['status'] == '2'){
                                                $fetch_attendance = $db_handle->runQuery("SELECT COUNT(att_id) as avail_num FROM `attendent` where schedule_id = {$fetch_session[$i]['schedule_id']}");
                                                $attendance = $fetch_attendance[0]['avail_num'];
                                            }
                                            echo $attendance;
                                            ?>
                                            / <?php echo $fetch_session[$i]['capacity'];?></h2>
                                        <span class="position"><?php echo $fetch_session[$i]['session_name'];?></span>
                                    </div>
                                    <span class="cd-icon bgl-success">
												<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M38.4998 10.4995H35.0002V38.4999H38.4998C40.4245 38.4999 42 36.9238 42 34.9992V13.9992C42 12.075 40.4245 10.4995 38.4998 10.4995Z" fill="#2BC155"/>
													<path d="M27.9998 10.4995V6.9998C27.9998 5.07515 26.4243 3.49963 24.5001 3.49963H17.4998C15.5757 3.49963 14.0001 5.07515 14.0001 6.9998V10.4995H10.5V38.4998H31.5V10.4995H27.9998ZM24.5001 10.4995H17.4998V6.99929H24.5001V10.4995Z" fill="#2BC155"/>
													<path d="M3.50017 10.4995C1.57551 10.4995 0 12.075 0 13.9997V34.9997C0 36.9243 1.57551 38.5004 3.50017 38.5004H6.99983V10.4995H3.50017Z" fill="#2BC155"/>
												</svg>
											</span>
                                </div>
                            </div>
                            <span class="line bg-success"></span>
                        </div>
                    </div>
                    <?php
                }
                ?>
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
    <?php include ('include/js.php');?>
    
    <script>
        setTimeout(function(){
            location.reload();
        }, 30000);
    </script>
</body>

</html>