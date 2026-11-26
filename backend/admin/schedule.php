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



    $insert_code = $db_handle->insertQuery("INSERT INTO `schedule`(`session_name`, `host_organization`, `modality`, `theme`, `description`, `capacity`, `date`, `time`, `title`, `venue`, `status`, `inserted_at`)
VALUES ('$session_name','$host_organization','$modality','$theme','$description','$capacity','$date','$time','$session_title','$venue','$type','$inserted_at')");
    if($insert_code){
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
    <title>Schedule - Toilet Conference</title>
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Schedule</a></li>
                </ol>
            </div>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">Create Schedule</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="#" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title">Create Schedule</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="session_name" placeholder="Session Name/Number">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="session_title" placeholder="Session Title">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="host_organization" placeholder="Host Organization">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="theme" placeholder="Theme">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="venue" placeholder="Venue">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="capacity" placeholder="Capacity">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="modality" placeholder="Modality">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="date" placeholder="Date">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-rounded" name="time" placeholder="Time">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" id="comment" name="description">Description</textarea>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control form-control-lg default-select" name="type">
                                            <option>Select Type</option>
                                            <option value="0">Private</option>
                                            <option value="1">Public</option>
                                            <option value="2">Avail</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                <button type="submit" name="assign_task" class="btn btn-primary">Create Schedule</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Schedule List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Name/Number</th>
                                        <th>Title</th>
                                        <th>Host</th>
                                        <th>Theme</th>
                                        <th>Modality</th>
                                        <th>Venue</th>
                                        <th>Capacity</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fetch_session = $db_handle->runQuery("SELECT * FROM `schedule` ORDER BY `schedule_id` DESC");
                                    $fetch_session_no = $db_handle->numRows("SELECT * FROM `schedule` ORDER BY `schedule_id` DESC");

                                    for ($i=0; $i<$fetch_session_no; $i++){
                                        ?>
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php echo $fetch_session[$i]['date'];?></td>
                                            <td><?php echo $fetch_session[$i]['time'];?></td>
                                            <td><?php echo $fetch_session[$i]['session_name'];?></td>
                                            <td><?php echo $fetch_session[$i]['title'];?></td>
                                            <td><?php echo $fetch_session[$i]['host_organization'];?></td>
                                            <td><?php echo $fetch_session[$i]['theme'];?></td>
                                            <td><?php echo $fetch_session[$i]['modality'];?></td>
                                            <td><?php echo $fetch_session[$i]['venue'];?></td>
                                            <td><?php echo $fetch_session[$i]['capacity'];?></td>
                                            <td><?php echo $fetch_session[$i]['description'];?></td>
                                            <td><?php if($fetch_session[$i]['status'] == '0')
                                                {
                                                    ?>
                                                    <span class="badge badge-rounded badge-danger">Private</span>
                                                    <?php
                                                } else if($fetch_session[$i]['status'] == '1') {
                                                ?>
                                                    <span class="badge badge-rounded badge-success">Public</span>
                                                    <?php
                                                } else{
                                                ?>
                                                    <span class="badge badge-rounded badge-warning">Avail</span>
                                                    <?php
                                                }
                                                ?></td>
                                            <td> <a href="Edit-Schedule?id=<?php echo $fetch_session[$i]['schedule_id'];?>" class="btn btn-warning shadow btn-xs sharp"><i
                                                            class="fa fa-pencil"></i></a></td>
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