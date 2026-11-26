<?php
session_start();

require_once('../config/dbConfig.php');
$db_handle = new DBController();
date_default_timezone_set("Asia/Dhaka");
$inserted_at = date("d F Y");

if(isset($_GET['user'])){
    $unique_id = $_GET['user'];
    $fetch_details = $db_handle->runQuery("SELECT unique_id,title,first_name,surname,invoice_no,items, price, grand_total,city,discount,tour_discount,email,phone,invoice_data.updated_at,invoice_data.inserted_at,nationality,gender,organization,designation,dietary,accessibility FROM `users`,`ticket_data`,`invoice_data` WHERE users.user_id = invoice_data.user_id and users.user_id = ticket_data.user_id and users.unique_id ='$unique_id'");

    $get_qr = $db_handle->runQuery("select * from user_qr where unique_id ='$unique_id'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Confirmation - Toilet Conference</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        /*
        Main color: #1e8fc8
        Sub color: #e2eff5
        Dark blue color: #2d3999
        Black color: #0e0101
         */
        @font-face {
            font-family: heading;
            src: url(CoreSansA75ExtraBold.otf);
        }
        body {
            font-family: 'Noto Sans', sans-serif;
            margin: 0;
        }

        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .header .row {
            padding: 20px 0;
        }

        .header img {
            max-width: 250px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .details p {
            margin: 5px 0;
        }


        .qr-code img {
            width: 100%;
            height: 100%;
        }

        table.invoice {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.invoice th, table.invoice td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table.invoice thead tr{
            background-color: #1e8fc8;
            color: white;
        }
        table.invoice tbody tr{
            color: #2d3999;
        }

        table.invoice tbody tr:nth-child(even) {
            background-color: #e2eff5;
        }

        .total {
            text-align: right;
            margin-top: 20px;
        }

        .total h2 {
            margin: 0;
        }

        .total p{
            color: #2d3999;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #2d3999;
        }
        .grand_total{
            background: #1e8fc8;
            padding: 10px 20px;
            font-size: 24px;
            color: #fff;
        }
        .left-info p{
            margin: 0 !important;
        }
        .left-info-header p{
            font-weight: bold;
            color: #1e8fc8;
        }

        .heading-right {
            font-size: 30px;
            color: #000000;
            text-transform: capitalize;
            font-family: heading;
            letter-spacing: 2px;
        }
        .details-left {
            font-size: 16px;
            color: #1e8fc8;
        }
        .details-right{
            font-size: 16px;
            line-height: 1;
        }
        .info_heading {
            font-size: 16px;
            font-weight: 900;
            color: #2d3999;
            padding-bottom: 10px;
            border-bottom: 3px solid #ccc;
            font-family: heading;
        }
        .account-info p{
            font-size: 15px;
            margin-bottom: 0.8rem !important;
        }

    </style>
</head>
<body>
<div class="invoice-container" id="submit-pdf">
    <div class="header">
        <div class="row">
            <div class="col-6 my-auto" style="background: #1e8fc80f; padding: 20px 10px;">
                <p><b>Issue Date: <?php echo date("d F Y", strtotime($fetch_details[0]['inserted_at']));?></b></p>
                <h3 class="heading-right" style="color: #2d3999;">Registration Confirmation</h3>
            </div>
            <div class="col-6 d-flex align-items-end justify-content-end">
                <img src="logo.jpg" alt="Logo" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8 left-content">
            <p>Thank you for registering for the Toilet Conference 2025. We’re thrilled to have you on
                board this year! Now that your registration is complete, please keep an eye on your inbox
                for necessary information on Toilet Conference 2025. <b>Please present the registration confirmation at the registration booth of
                the conference to collect your personalised conference ID</b></p>
            <h6>Contact Information:</h6>
            <p style="padding-top: 0 !important;">For questions related to your registration, contact <b>registration@toiletconference.org</b>
                </br></br>We look forward to seeing you at the Toilet Conference 2025!</p>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-8">
            <div class="row">
                <div class="col-12">
                    <h2 class="info_heading">PARTICIPANT INFORMATION</h2>
                </div>
                <div class="col-4">
                    <div class="info">
                        <p><strong>Name:</strong></p>
                        <p><strong>Contact number:</strong></p>
                        <p><strong>Email address:</strong></p>
                        <p><strong>Nationality:</strong></p>
                        <p><strong>Gender:</strong></p>
                        <p><strong>City of residence:</strong></p>
                        <p><strong>Dietary preference:</strong></p>
                        <p><strong>Accessibility need:</strong></p>
                    </div>
                </div>
                <div class="col-8">
                    <div class="info">
                        <p><?php echo $fetch_details[0]['title'] .' '.$fetch_details[0]['first_name'].' '.$fetch_details[0]['surname']; ?></p>
                        <p><?php echo $fetch_details[0]['phone'];?></p>
                        <p><?php echo $fetch_details[0]['email'];?></p>
                        <p><?php echo $fetch_details[0]['nationality'];?></p>
                        <p><?php echo $fetch_details[0]['gender'];?></p>
                        <p><?php echo $fetch_details[0]['city'];?></p>
                        <p><?php echo $fetch_details[0]['dietary'];?></p>
                        <p><?php echo $fetch_details[0]['accessibility'];?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 d-flex align-items-center justify-content-end">
            <img src="qr/<?php echo $get_qr[0]['file'];?>" alt="QR Code" style="width: 200px; height: auto">
        </div>
    </div>

    <table class="invoice mt-3">
        <thead>
        <tr>
            <th>NO</th>
            <th>DESCRIPTION</th>
            <th class="text-end">QTY</th>
            <th class="text-end">UNIT PRICE</th>
            <th class="text-end">PRICE</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $item_array = explode(',', $fetch_details[0]['items']);
        $item_unit_price = explode(',', $fetch_details[0]['price']);
        $item_city = explode(',', $fetch_details[0]['city']);

        $total=0;

        for ($i = 0; $i < count($item_array); $i++) {
            ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo $item_array[$i]; ?></td>
                <td class="text-end">1</td>
                <td class="text-end"><?php
                    if($item_city[0]=="Bangladesh")
                        echo "৳ ".number_format($item_unit_price[$i]);
                    else
                        echo "$ ".number_format($item_unit_price[$i]);
                    ?></td>
                <td class="text-end">
                    <?php
                    if($item_city[0]=="Bangladesh")
                        echo "৳ ".number_format($item_unit_price[$i]);
                    else
                        echo "$ ".number_format($item_unit_price[$i]);
                    ?>
                </td>
            </tr>
            <?php
            $total+=$item_unit_price[$i];
        }
        ?>

        </tbody>
    </table>


    <div class="row">
        <div class="col-8">
            <div class="left-info">
                <div class="row mt-5">
                    <div class="col-3 mt-5 left-info-header">
                        <p>Invoice no :</p>
                        <p>Invoice Date :</p>
                        <p>Payment Status :</p>
                    </div>
                    <div class="col-9 mt-5">
                        <p><b><?php echo $fetch_details[0]['invoice_no'];?></b></p>
                        <p><b><?php echo date("d F Y", strtotime($fetch_details[0]['updated_at']));?></b></p>
                        <p style="color: green;"><b>Paid</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="total">
                <p><strong>Sub Total:</strong> <?php
                    if($item_city[0]=="Bangladesh")
                        echo "৳ ".number_format($total);
                    else
                        echo "$ ".number_format($total);
                    ?></p>

                <p><strong>Discount:</strong> <?php
                    if($item_city[0]=="Bangladesh")
                        echo "৳ ".number_format($fetch_details[0]['discount'] + $fetch_details[0]['tour_discount']);
                    else
                        echo "$ ".number_format($fetch_details[0]['discount'] + $fetch_details[0]['tour_discount']);
                    ?></p>

                <h2 class="grand_total text-end">Grand Total:  <?php
                    if($item_city[0]=="Bangladesh")
                        echo "৳ ".number_format($total - $fetch_details[0]['discount'] - $fetch_details[0]['tour_discount']);
                    else
                        echo "$ ".number_format($total - $fetch_details[0]['discount'] - $fetch_details[0]['tour_discount']);

                    ?>
                    <br>
                    <small class="mt-3" style="font-size: 12px"><i>* All prices are inclusive of VAT and Tax</i></small>
                </h2>
            </div>
        </div>
    </div>

    <div style="margin-top: 40px; line-height: 1;">
        <p style="font-weight: bold">Conference Secretariat</p>
        <p>House 97/B, Road 25, Block A, Banani, Dhaka, 1213, Bangladesh</p>
        <p><a href="mailto:info@toiletconference.org" target="_blank">info@toiletconference.org</a> | <a href="https://www.toiletconference.org" target="_blank">www.toiletconference.org</a></p>
    </div>
</div>

<div class="text-center mb-5">
    <button type="button" class="btn btn-primary" onclick="getPDF();">Download</button>
    <a href="https://regtoiletconference.org/profile" class="btn btn-warning">Back to Home</a>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"
        integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    function getPDF() {
        let currentDateTime = new Date();
        let customName = "<?php echo $fetch_details[0]['unique_id']; ?>-Toilet-";

        let year = currentDateTime.getFullYear();
        let month = currentDateTime.getMonth() + 1;
        let day = currentDateTime.getDate();

        let hours = currentDateTime.getHours();
        let minutes = currentDateTime.getMinutes();
        let seconds = currentDateTime.getSeconds();

        let formattedDate = year + '' + (month < 10 ? '0' : '') + month + '' + (day < 10 ? '0' : '') + day;
        let formattedTime = (hours < 10 ? '0' : '') + hours + '' + (minutes < 10 ? '0' : '') + minutes + '' + (seconds < 10 ? '0' : '') + seconds;

        let formattedDateTime = customName + formattedDate + formattedTime;


        let element = document.getElementById('submit-pdf');

        let opt = {
            margin: 0.1,
            filename: formattedDateTime + '.pdf',
            image: {type: 'png', quality: 1},
            html2canvas: {scale: 1},
            jsPDF: {unit: 'in', format: [13, 19], orientation: 'portrait'}
        };

        html2pdf().set(opt).from(element).save();
    }
</script>
</body>
</html>
