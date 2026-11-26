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
    $fetch_details = $db_handle->runQuery("select * from ticket_data, invoice_data where ticket_data.user_id = invoice_data.user_id and ticket_data.user_id = '".$_GET['user']."'");
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">User Details</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card profile-card">
                                        <div class="card-body">
                                            <form>
                                                <div class="mb-sm-5 mb-2">
                                                    <div class="title mb-4"><span class="fs-18 text-black font-w600">Generals</span></div>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Title</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['title'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>First Name</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['first_name'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Last Name</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['surname'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Official Email</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['official_email'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Contact Number</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['phone'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Country</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['city'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Nationality</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['nationality'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Gender</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['gender'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Birth Year</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['birth_year'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-sm-5 mb-2">
                                                    <div class="title mb-4"><span class="fs-18 text-black font-w600">Employment History</span></div>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                    <label>Status</label>
                                                                    <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['student'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Organization</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['organization'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Designation</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['designation'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label>Student File</label>
                                                                <iframe src="<?php echo $fetch_details[0]['student_file'];?>" width="100%" height="500px"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-sm-5 mb-2">
                                                    <div class="title mb-4"><span class="fs-18 text-black font-w600">Visa Details</span></div>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Visa Invitation</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['visa_invitation'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Passport / Other Identification Number</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['passport_no'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Issue Date</label>
                                                                <input type="text" class="form-control" disabled value="<?php
                                                                if($fetch_details[0]['issue_date'] != '0000-00-00'){
                                                                    echo date("d F Y", strtotime($fetch_details[0]['issue_date']));
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Expire Date</label>
                                                                <input type="text" class="form-control" disabled value="<?php
                                                                if($fetch_details[0]['expire_date'] != '0000-00-00'){
                                                                    echo date("d F Y", strtotime($fetch_details[0]['expire_date']));
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12 col-12">
                                                            <label>File</label>
                                                            <iframe src="<?php echo $fetch_details[0]['passport_file'];?>" width="100%" height="500px"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-sm-5 mb-2">
                                                    <div class="title mb-4"><span class="fs-18 text-black font-w600">Other Details</span></div>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Dietary</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['dietary'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Accessibility</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['accessibility'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Language</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['language'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label>Items</label>
                                                                <textarea class="form-control" disabled><?php echo $fetch_details[0]['items'];?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Notification</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['notification'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-sm-5 mb-2">
                                                    <div class="title mb-4"><span class="fs-18 text-black font-w600">Payment Details</span></div>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Total Amount</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['grand_total'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Registration Discount</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['discount'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Tour Discount</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['tour_discount'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Registration Promo Code</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['registratio_promo'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Tour Promo Code</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['tour_promo'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Invoice Number</label>
                                                                <input type="text" class="form-control" disabled value="<?php echo $fetch_details[0]['invoice_no'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-sm-5 mb-2">
                                                    <div class="title mb-4"><span class="fs-18 text-black font-w600">Payment Proof</span></div>
                                                    <div class="col-xl-12 col-12">
                                                        <label>File</label>
                                                        <iframe src="../<?php echo $fetch_details[0]['proof'];?>" width="100%" height="500px"></iframe>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                            if($fetch_details[0]['payment_status'] == '0'){
                                                ?>
                                                <a href="Update-Payment?user=<?php echo $fetch_details[0]['invoice_id'];?>" class="ml-3 btn btn-danger shadow"><i
                                                            class="fa fa-pencil"></i>Change Payment Status</a>
                                                <?php
                                            }
                                            ?>
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