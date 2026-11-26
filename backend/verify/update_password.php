<?php
require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");

if(isset($_POST['setPassword'])){
    $password = $db_handle->checkValue($_POST['password']);
    $confirm_password = $db_handle->checkValue($_POST['confirm_password']);
    $uid = $db_handle->checkValue($_POST['uid']);
    if($password == $confirm_password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $update_password = $db_handle->insertQuery("update users set password = '{$hashedPassword}' where unique_id = '$uid'");
        if($update_password){
            echo "
            <script>
            alert('Password updated successfully! Please login with the new password!');
            window.location.href='https://regtoiletconference.org/';
</script>
            ";
        } else {
            echo "
        <script>
        alert('Something went wrong.');
        window.location.href='https://regtoiletconference.org/verify/update_password.php?user=".$uid."';
</script>
        ";
        }
    } else{
        echo "
        <script>
        alert('Password and Confirm Password do not match!');
        window.location.href='https://regtoiletconference.org/verify/update_password.php?user=".$uid."';
</script>
        ";
    }
}

if(isset($_GET['user'])){
    $user = $_GET['user'];
} else {
    echo "
    <script>
    alert ('You are may be lost!')
    window.location.href = 'https://regtoiletconference.org/Login';
</script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Your Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        /* Resetting margin and padding */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Flexbox to center content vertically and horizontally */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
        }

        /* Responsive image styling */
        .image {
            max-width: 100%;
            height: auto;
        }

        /* Styling for the text */
        .text {
            font-size: 1.5rem;
            margin-top: 20px;
            color: #333;
        }

        /* Responsive text size */
        @media (max-width: 600px) {
            .text {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Image element -->
    <img src="logo.png" alt="Placeholder Image" class="image">
    <h3 class="mt-5">Please set a new password for your account</h3>

    <form class="mt-5" action="" method="post" style="width: 100%">
        <input type="hidden" name="uid" value="<?php echo $_GET['user']; ?>">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">New Password</label>
            <input type="password" name="password" minlength="8" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" minlength="8" id="exampleInputPassword1" required>
        </div>

        <button type="submit" name="setPassword" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
