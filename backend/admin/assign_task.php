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

if(isset($_POST['assign_task'])){
    $task_details = $db_handle->checkValue($_POST['task_details']);
    $volunteer_id = $db_handle->checkValue($_POST['volunteer_id']);
    $date = $db_handle->checkValue($_POST['date']);
    $time = $db_handle->checkValue($_POST['time']);


    $insert_code = $db_handle->insertQuery("INSERT INTO `tasks`(`volunteer_id`, `task`, `inserted_at`,`date`, `time`) VALUES ('$volunteer_id','$task_details','$inserted_at','$date','$time')");
    if($insert_code){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Assign-Task';
                </script>";
    } else{
        echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href = 'Assign-Task';
                </script>";
    }
}

if(isset($_GET['task_id'])){
    $dlt_task = $db_handle->insertQuery("DELETE FROM `tasks` WHERE `task_id` = {$_GET['task_id']}");
    if($dlt_task){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Assign-Task';
                </script>";
    } else{
        echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href = 'Assign-Task';
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
    <title>Create Volunteer - Toilet Conference</title>
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Assign Task</a></li>
                </ol>
            </div>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">Assign Task to Volunteer</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign Task to Volunteer</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" id="comment" name="task_details" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control form-control-lg default-select" name="volunteer_id" required>
                                            <option>Select Volunteer</option>
                                            <?php
                                            $fetch_volunteer = $db_handle->runQuery("select * from admin_login where type = '1' order by admin_id desc");
                                            $fetch_volunteer_no = $db_handle->numRows("select * from admin_login where type = '1' order by admin_id desc");
                                            for($i=0;$i<$fetch_volunteer_no;$i++){
                                                ?>
                                                <option value="<?php echo $fetch_volunteer[$i]['admin_id']?>"><?php echo $fetch_volunteer[$i]['admin_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="form-group">
                                            <lable>Date</lable>
                                            <input type="text" class="form-control input-default" name="date" placeholder="Date">
                                        </div>
                                        <div class="form-group">
                                            <lable>Time</lable>
                                            <input type="text" class="form-control input-default" name="time" placeholder="time">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                <button type="submit" name="assign_task" class="btn btn-primary">Assign Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Task List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Volunteer Name</th>
                                        <th>Task</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fetch_tasks = $db_handle->runQuery("SELECT * FROM `admin_login`,`tasks` where admin_login.type = 1 and admin_login.admin_id = tasks.volunteer_id order by tasks.task_id desc;");
                                    $fetch_tasks_no = $db_handle->numRows("SELECT * FROM `admin_login`,`tasks` where admin_login.type = 1 and admin_login.admin_id = tasks.volunteer_id order by tasks.task_id desc;");

                                    for ($i=0; $i<$fetch_tasks_no; $i++){
                                        ?>
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php echo $fetch_tasks[$i]['admin_name'];?></td>
                                            <td><?php echo $fetch_tasks[$i]['task'];?></td>
                                            <td><?php echo $fetch_tasks[$i]['date'];?></td>
                                            <td><?php echo $fetch_tasks[$i]['time'];?></td>
                                            <td><a href="Assign-Task?task_id=<?php echo $fetch_tasks[$i]['task_id'];?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a></td>
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