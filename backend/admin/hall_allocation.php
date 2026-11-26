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

if(isset($_GET['volunteer'])){
    if(isset($_POST['assign_hall'])){
        $hall = $db_handle->checkValue($_POST['hall']);
        $insert_code = $db_handle->insertQuery("update admin_login set allocated_hall = '$hall' where admin_id = {$_GET['volunteer']}");
        if($insert_code){
            echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Create-Volunteer';
                </script>";
        }
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Hall Allocation</a></li>
                </ol>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Hall Allocation</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <select class="form-control form-control-lg default-select" name="hall" required>
                                            <option>Select Hall</option>
                                            <?php
                                            $fetch_hall = $db_handle->runQuery("select * from halls");
                                            foreach ($fetch_hall as $hall) {
                                                ?>
                                                <option value="<?php echo $hall['hall_id']?>"><?php echo $hall['hall_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="assign_hall" class="btn btn-primary">Assign Hall</button>
                                </form>
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