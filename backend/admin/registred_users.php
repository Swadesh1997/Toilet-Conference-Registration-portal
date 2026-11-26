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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Designation</th>
                                        <th>Organization</th>
                                        <th>Registrations</th>
                                        <th>Payment Proof</th>
                                        <th>Registration Discount</th>
                                        <th>Tour Discount</th>
                                        <th>Paid Amount</th>
                                        <th>Paid Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $fetch_users = $db_handle->runQuery("SELECT users.user_id, users.email, ticket_data.title, ticket_data.first_name, ticket_data.surname, ticket_data.phone, ticket_data.organization, ticket_data.designation, ticket_data.city, invoice_data.items, invoice_data.price, invoice_data.grand_total, invoice_data.discount, invoice_data.tour_discount, invoice_data.invoice_id, invoice_data.invoice_no, invoice_data.payment_status,invoice_data.proof FROM `invoice_data`, ticket_data, users WHERE users.user_id = invoice_data.user_id and users.user_id = ticket_data.user_id and invoice_data.user_id = ticket_data.user_id order by invoice_data.invoice_id desc;");
                                    $fetch_users_no = $db_handle->numRows("SELECT users.user_id, users.email, ticket_data.title, ticket_data.first_name, ticket_data.surname, ticket_data.phone, ticket_data.city, invoice_data.items, invoice_data.price, invoice_data.grand_total, invoice_data.discount, invoice_data.tour_discount, invoice_data.invoice_id, invoice_data.invoice_no, invoice_data.payment_status,invoice_data.proof FROM `invoice_data`, ticket_data, users WHERE users.user_id = invoice_data.user_id and users.user_id = ticket_data.user_id and invoice_data.user_id = ticket_data.user_id order by invoice_data.invoice_id desc;");

                                    for ($i=0; $i<$fetch_users_no; $i++){
                                        $check_payment_method = $db_handle->numRows("select * from transactions where invoice_id = {$fetch_users[$i]['invoice_no']}");
                                        if($check_payment_method == 0){
                                            ?>
                                            <tr>
                                                <td><?php echo $i+1;?></td>
                                                <td><?php echo $fetch_users[$i]['title'] .' '.$fetch_users[$i]['first_name'].' '.$fetch_users[$i]['surname'];?></td>
                                                <td><?php echo $fetch_users[$i]['email'];?></td>
                                                <td><?php echo $fetch_users[$i]['phone'];?></td>
                                                <td><?php echo $fetch_users[$i]['designation'];?></td>
                                                <td><?php echo $fetch_users[$i]['organization'];?></td>
                                                <td><?php echo $fetch_users[$i]['items'];?></td>
                                                <td><?php if ($fetch_users[$i]['proof'] == null) echo "No"; else echo "Yes"?></td>
                                                <td><?php echo $fetch_users[$i]['discount'];?></td>
                                                <td><?php echo $fetch_users[$i]['tour_discount'];?></td>
                                                <td><?php echo $fetch_users[$i]['grand_total'];?></td>
                                                <td><?php
                                                    if($fetch_users[$i]['payment_status'] == '0'){
                                                        ?>
                                                        <span class="ml-3 btn btn-danger shadow sharp">Due</span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="ml-3 btn btn-success shadow sharp">Paid</span>
                                                        <?php
                                                    }
                                                    ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="User-Details?user=<?php echo $fetch_users[$i]['user_id'];?>" class="btn btn-warning shadow btn-xs sharp"><i
                                                                    class="fa fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
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