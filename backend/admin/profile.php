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

if(isset($_POST['update_password'])){
    $password = $db_handle->checkValue($_POST['password']);
    $new_password = $db_handle->checkValue($_POST['new_password']);
    $fetch_password = $db_handle->runQuery("SELECT * FROM admin_login WHERE admin_id = '".$_SESSION['admin_id']."'");
    $hashed_password = $fetch_password[0]['admin_password'];
    if(password_verify($password, $hashed_password)){
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password = $db_handle->insertQuery("update admin_login set admin_password = '".$new_hashed_password."' where admin_id = '".$_SESSION['admin_id']."'");
        if($update_password){
            echo "<script>
                document.cookie = 'alert = 3;';
                window.location.href='Profile';
                </script>";
        }
    } else{
        echo "<script>
                document.cookie = 'alert = 5;';
                window.location.href='Profile';
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
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form id="passwordForm" action="#" method="post">
                                    <div class="form-group">
                                        <input type="password" id="password" name="password" class="form-control input-default" placeholder="old password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" id="new_password" name="new_password" class="form-control input-default" placeholder="new password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control input-default" placeholder="confirm new password" required>
                                    </div>
                                    <div id="error-message" style="color: red; display: none;">Passwords do not match!</div>
                                    <button type="submit" class="btn light btn-primary" name="update_password">Update Password</button>
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
<script>
    document.getElementById('passwordForm').addEventListener('submit', function(event) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorMessage = document.getElementById('error-message');

        // Check if passwords match
        if (newPassword !== confirmPassword) {
            // Prevent form submission
            event.preventDefault();

            // Show error message
            errorMessage.style.display = 'block';
        } else {
            // Hide error message if it matches
            errorMessage.style.display = 'none';
        }
    });
</script>
</body>

</html>