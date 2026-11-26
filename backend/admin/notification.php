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

if(isset($_POST['add_notification'])){
    $message = $db_handle->checkValue($_POST['message']);
    $type = $db_handle->checkValue($_POST['type']);

    $insert_notification = $db_handle->insertQuery("INSERT INTO `notifications`(`notification`, `noti_type`, `inserted_at`) VALUES ('$message','$type','$inserted_at')");
    if($insert_notification){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Notification';
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
    <title>Notification - Toilet Conference</title>
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Notifications</a></li>
                </ol>
            </div>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">Add Notification</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="#" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Notification</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <input type="text" name="message" class="form-control input-default " placeholder="Message" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control form-control-lg default-select" name="type" required>
                                            <option>Select Type</option>
                                            <option value="1">For Guests</option>
                                            <option value="2">For Volunteer</option>
                                            <option value="3">For both  Volunteers and Guests</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                <button type="submit" name="add_notification" class="btn btn-primary">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Notifications</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Message</th>
                                        <th>Type</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fetch_notification = $db_handle->runQuery("SELECT * FROM `notifications` ORDER BY `notifications`.`notification_id` DESC");
                                    $fetch_notification_no = $db_handle->numRows("SELECT * FROM `notifications` ORDER BY `notifications`.`notification_id` DESC");

                                    for ($i=0; $i<$fetch_notification_no; $i++){
                                        ?>
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php echo $fetch_notification[$i]['notification'];?></td>
                                            <td><?php
                                                if($fetch_notification[$i]['noti_type'] == '1') echo 'For Guests';
                                                if($fetch_notification[$i]['noti_type'] == '2') echo 'For Volunteers';
                                                if($fetch_notification[$i]['noti_type'] == '3') echo 'For Both';
                                            ?></td>
                                            <td>
                                                <a href="Delete-Notification?noti_id=<?php echo $fetch_notification[$i]['notification_id'];?>" class="btn btn-warning shadow btn-xs sharp"><i class="fa fa-eye"></i></a>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
<?php include ('include/js.php');?>
</body>

</html>