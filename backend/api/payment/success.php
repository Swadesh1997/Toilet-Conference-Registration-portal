<?php
session_start();
require_once('../../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("Y-m-d H:i:s");
include('../../admin/phpqrcode/qrlib.php');

$val_id=urlencode($_POST['val_id']);
$store_id=urlencode(env('SSLCZ_STORE_ID'));
$store_passwd=urlencode(env('SSLCZ_STORE_PASSWORD'));
$requested_url = (env('SSLCZ_VALIDATION_URL', 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php')."?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requested_url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

$result = curl_exec($handle);

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle)))
{

    # TO CONVERT AS OBJECT
    $result = json_decode($result);

    # TRANSACTION INFO
     $status = $result->status;
    $tran_date = $result->tran_date;
    $tran_id = $result->tran_id;
    $val_id = $result->val_id;
    $amount = $result->amount;
    $store_amount = $result->store_amount;
    $bank_tran_id = $result->bank_tran_id;
    $card_type = $result->card_type;
    $invoice = $result->value_a;

    if($status == "VALID"){
        $add_transaction = $db_handle->insertQuery("INSERT INTO `transactions`(`transaction_id`, `invoice_id`, `paid_amount`, `store_amount`, `bank_transaction_id`, `card_type`, `transaction_date`, `inserted_at`) 
VALUES ('$tran_id','$invoice','$amount','$store_amount','$bank_tran_id','$card_type','$tran_date','$inserted_at')");
            $update_status = $db_handle->insertQuery("update invoice_data set payment_status = 1, updated_at='$inserted_at' where invoice_no = '$invoice'");
            $fetch_user_id = $db_handle->runQuery("select user_id from invoice_data where invoice_no = '$invoice'");
            $user_id = $fetch_user_id[0]["user_id"];
            $fetch_user_info = $db_handle->runQuery("select * from ticket_data where user_id = {$user_id}");
            $fetch_unique_id = $db_handle->runQuery("select unique_id,user_id from users where user_id = {$user_id}");
            $data = $fetch_unique_id[0]['unique_id'];
            $file_name = $data.'.png';
            $file = '../../user_invoice/qr/'.$file_name;
            QRcode::png($data, $file, QR_ECLEVEL_L, 10);

            $insert_qr = $db_handle->insertQuery("INSERT INTO `user_qr`(`user_id`, `unique_id`, `file`, `inserted_at`) VALUES ('{$fetch_unique_id[0]['user_id']}','$data','$file_name','$inserted_at')");
            $user_email = $db_handle->runQuery("SELECT email,official_email FROM `users`,`ticket_data` WHERE users.user_id = ticket_data.user_id and users.user_id = '$user_id'");
        echo "
        <script>
        alert('Your payment is successful please login to download invitation.');
        window.location.href='https://regtoiletconference.org/Logout';
</script>
        ";
    }

} else {
    echo "Failed to connect with SSLCOMMERZ";
}