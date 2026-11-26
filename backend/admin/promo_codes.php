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

if(isset($_POST['generate_promo'])){
    $code = $db_handle->checkValue($_POST['code']);
    $discount = $db_handle->checkValue($_POST['discount']);

    $insert_code = $db_handle->insertQuery("INSERT INTO `promo_code`(`code`, `discount`, `inserted_at`) VALUES ('$code','$discount','$inserted_at')");
    if($insert_code){
        echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href = 'Promo-Codes;';
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
    <title>Dashboard - Toilet Conference</title>
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
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">Generate Promo Codes</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="#" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Generate Promo Code</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <input type="text" name="code" class="form-control input-default " placeholder="Add Promo Code" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="discount" class="form-control input-default " placeholder="Discount Percentage" required autocomplete="off">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <button type="submit" name="generate_promo" class="btn btn-primary">Generate</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Promo Codes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Code</th>
                                        <th>Discount (%)</th>
                                        <th>Generated At</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fetch_promo_code = $db_handle->runQuery("SELECT * FROM `promo_code` order by `inserted_at` DESC");
                                    $fetch_promo_code_no = $db_handle->numRows("SELECT * FROM `promo_code` order by `inserted_at` DESC");

                                    for ($i=0; $i<$fetch_promo_code_no; $i++){
                                        ?>
                                        <tr>
                                            <td><?php echo $i+1;?></td>
                                            <td><?php echo $fetch_promo_code[$i]['code'];?></td>
                                            <td><?php echo $fetch_promo_code[$i]['discount'];?></td>
                                            <td><?php
                                                echo date("d M Y h:i A", strtotime($fetch_promo_code[$i]['inserted_at']));
                                                ?>
                                            </td>
                                            <td><?php if ($fetch_promo_code[$i]['status'] == 0) {
                                                ?>
                                                    <span class="badge badge-success">Not Used</span>
                                                    <?php
                                                } else {
                                                ?>
                                                    <span class="badge badge-danger">Used</span>
                                                <?php
                                                    }?></td>
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