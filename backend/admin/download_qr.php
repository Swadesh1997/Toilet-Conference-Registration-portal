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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Registered Users - Toilet Conference</title>
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Registered Users</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Registered Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Organization</th>
                                        <th>Student</th>
                                        <th>QR Code</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fetch_users = $db_handle->runQuery("select ticket_data.user_id,ticket_data.title, ticket_data.first_name, ticket_data.surname,ticket_data.organization,ticket_data.designation,ticket_data.student, user_qr.file from ticket_data, invoice_data,user_qr where ticket_data.user_id = invoice_data.user_id and invoice_data.payment_status = '1' and ticket_data.user_id = user_qr.user_id;");
                                    $fetch_users_no = $db_handle->numRows("select ticket_data.user_id,ticket_data.title, ticket_data.first_name, ticket_data.surname,ticket_data.organization,ticket_data.designation,ticket_data.student, user_qr.file from ticket_data, invoice_data,user_qr where ticket_data.user_id = invoice_data.user_id and invoice_data.payment_status = '1' and ticket_data.user_id = user_qr.user_id;");

                                    for ($i=0; $i<$fetch_users_no; $i++){
                                            ?>
                                            <tr>
                                                <td><?php echo $i+1;?></td>
                                                <td><?php echo $fetch_users[$i]['user_id']?></td>
                                                <td><?php echo $fetch_users[$i]['title'] .' '.$fetch_users[$i]['first_name'].' '.$fetch_users[$i]['surname'];?></td>
                                                <td><?php echo $fetch_users[$i]['designation'];?></td>
                                                <td><?php echo $fetch_users[$i]['organization'];?></td>
                                                <td><?php echo $fetch_users[$i]['student'];?></td>
                                                <td><img src="../user_invoice/qr/<?php echo $fetch_users[$i]['file'];?>" style="width: 200px; height: auto;"/></td>
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
<?php include('include/js.php'); ?>
</body>

</html>