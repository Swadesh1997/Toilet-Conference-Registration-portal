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

if(isset($_POST['create_volunteer'])){
    $volunteer_name = $db_handle->checkValue($_POST['volunteer_name']);
    $volunteer_email = $db_handle->checkValue($_POST['volunteer_email']);
    $volunteer_password = $db_handle->checkValue($_POST['volunteer_password']);

    $hashed_password = password_hash($volunteer_password, PASSWORD_DEFAULT);

    $insert_code = $db_handle->insertQuery("INSERT INTO `admin_login` (`admin_name`, `admin_email`, `admin_password`) VALUES ('$volunteer_name','$volunteer_email','$hashed_password')");
    if($insert_code){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Create-Volunteer;';
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Promo Codes</a></li>
                </ol>
            </div>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">Create Volunteer</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="#" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title">Create Volunteer</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <input type="text" name="volunteer_name" class="form-control input-default " placeholder="Add Volunteer Name" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="volunteer_email" class="form-control input-default " placeholder="Volunteer Email" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="volunteer_password" class="form-control input-default " placeholder="Password" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                <button type="submit" name="create_volunteer" class="btn btn-primary">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Volunteer List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fetch_promo_code = $db_handle->runQuery("SELECT * FROM `admin_login` where type = 1;");
                                    $fetch_promo_code_no = $db_handle->numRows("SELECT * FROM `admin_login` where type = 1;");

                                    for ($i=0; $i<$fetch_promo_code_no; $i++){
                                        ?>
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php echo $fetch_promo_code[$i]['admin_name'];?></td>
                                            <td><?php echo $fetch_promo_code[$i]['admin_email'];?></td>
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