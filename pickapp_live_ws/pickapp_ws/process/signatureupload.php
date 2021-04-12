<?php

include '../includes/dbconfig2.php';
include '../../mailer/config.php';
$now = date("Y-m-d H:i:s", strtotime('+8 hours'));

session_start();
$hid = $_SESSION['headerid'];
$hid_ = md5($hid);
$txtname = $_REQUEST['q'];

$new_image_name = $hid."_".$txtname.".jpg";
//move_uploaded_file($_FILES["file"]["tmp_name"], "../user_avatar/1/".$new_image_name);

$update = "Update request_header set signature = 'signatures/".$new_image_name."', param_key = '$hid_' where id = $hid";
$query = $conn2->query($update);

function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}

if($_FILES['file']['size'] > 50000){
	$d = compress($_FILES["file"]["tmp_name"], "../signatures/".$new_image_name, 10);
}else{
	move_uploaded_file($_FILES["file"]["tmp_name"], "../signatures/".$new_image_name);
}

$headerid = $hid;

$query = "SELECT * from request_details where request_header_id = $headerid";
$query = $conn2->query($query);
$numrows = mysqli_num_rows($query);

if($numrows > 0){
   $row = mysqli_fetch_assoc($query);
}

$query2 = "SELECT * from request_header where id = $headerid";
$query2 = $conn2->query($query2);
$row2 = mysqli_fetch_assoc($query2);

$driverID = $row2['assigned_driver'];
$packageID = $row['package_type'];
$requestorid = $row2['requested_by'];

//get package name
$package = "SELECT * from package_type where id = $packageID";
$package = $conn2->query($package);
$packageName = mysqli_fetch_assoc($package);
$packageType = $packageName['package_name'];

//get driver name
$driver = "SELECT * from mst_admin_user where id = $driverID";
$driver = $conn2->query($driver);
$driverName = mysqli_fetch_assoc($driver);
$driverfname = $driverName['fname'];
$driverlname = $driverName['lname'];

$query3 = "SELECT * from mst_user where id = $requestorid";
$query3 = $conn2->query($query3);
$row3 = mysqli_fetch_assoc($query3);

$transactionNumber = $s_number = str_pad( $headerid, 4, "0", STR_PAD_LEFT );
$toemail = $row3['emailadd'];
$signature = $row2['signature'];
if($row['note']){
    $note = $row['note'];
}else{
    $note = "No note.";
}

//check if signature exists

if(!$signature){
    $signaturePOST = 'No signature found.';
}else{
    $signaturePOST = '<img src="http://ws.yellox.ph/pickapp_ws/'.$signature.'"/>';
}

$to = $toemail;
// $to = "sonrheydeiparine2@gmail.com";
$subject = "Yello-X: Delivery Report #".$transactionNumber;
// $imgsig = "../signatures/".$new_image_name."";
$imgsig = $signaturePOST;
// $imghead = "../dr_header_logo.jpg";
$imghead = "http://ws.yellox.ph/pickapp_ws/dr_header_logo.jpg";


$requestdate = $row2['dateTime_requested'];
$pickupdate = $row2['dateTime_pick'];
$deliverydate = $row2['dateTime_delivered'];

$hourdiff = round((strtotime($deliverydate) - strtotime($requestdate))/3600, 1);
$hourdiff1 = $hourdiff." Hours / Minutes";

$message = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"/>
    <meta name="viewport" content="initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/7d3a544d39.js"></script>
    <style>
    *{
        margin: 0;
        padding: 0;
    }

    html, body{
        font-family: "Poppins", sans-serif !important;
        height: 100%;
        width: 100%;
    }

    .container {
    width: 100%;
    margin: auto;
    height: 100%;
    }

    .wrapper {
        display: table;
        background: #d5d5d5;
        height: 100%;
        width: 100%;
    }   

    .orders_wrapper {
        text-align: center;
        margin: 10px 0;
    }

    .subwrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .header_wrapper {
        display: flex;
    }

    .body {
        width: 90%;
        margin: auto;
    }

    .body_wrapper {
    background: white;
    padding: 3em;
    }

    .items_wrapper {
        border: 2px solid #959595;
        padding: 1em;
    }
    
    .header {
        padding: 1em;
        width: 90%;
        margin: auto;
    }

    .signatures_wrapper{
        text-align: center;
    }

    .text-muted {
        color: #919191;
    }

    h6.dynamic_data {
        margin: 3px 0;
        font-size: 13px;
    }

    .items_wrapper div {
        margin: 10px 0;
    }

    .cost_wrapper {
        display: table;
        height: 100%;
        width: 100%;
    }

    .cost_subwrapper {
        display: table-cell;
        vertical-align: middle;
        text-align: left;
    }

    .branding {
        text-align: center;
        margin: 10px 0;
        font-style: italic;
    }

    .header_wrapper .cost{
        width: 50%;
    }

    .header_wrapper .dates{
        width: 50%;
    }

    .dates_wrapper {
        text-align: right;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="branding">
            <img src="'.$imghead.'" width="330" height="50">
            <h3>Thanks for choosing Yello - X, <span class="account_name">'.$row3['firstname'].' '.$row3['lastname'].'</span></h3>
        </div>
        <div class="wrapper">
            <div class="subwrapper">
                <div class="header">
                    <div class="header_wrapper">
                        <div class="cost">
                            <div class="cost_wrapper">
                                <div class="cost_subwrapper">
                                    <label>Total Price (PHP)</label>
                                    <h6 class="dynamic_data">&#8369; '.$row['cost'].'</h6>
                                </div>
                            </div>
                        </div>
                        <div class="dates">
                                <div class="dates_wrapper">
                                    <div class="date_pickup">
                                    <label>Date Requested</label>
                                    <h6 class="dynamic_data">'.$requestdate.'</h6>
                                </div>
                                <div class="date_pickup">
                                    <label>Date Pickup</label>
                                    <h6 class="dynamic_data">'.$pickupdate.'</h6>
                                </div>
                                <div class="date_delivered">
                                    <label>Date Delivered</label>
                                    <h6 class="dynamic_data">'.$deliverydate.'</h6>
                                </div>
                                <div class="duration">
                                    <label>Duration</label>
                                    <h6 class="dynamic_data">'.$hourdiff1.'</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="body">
                    <div class="body_wrapper">
                        <div class="items_wrapper">
                            <div class="item_1">
                                <label><span class="fa fa-circle"></span>Pickup: <b>'.$row['origin_address'].'</b></label>
                                <h6 class="dynamic_data"><span style="font-weight: normal !important">Recipient:</span> '.$row['sender_name'].'</h6>    
                            </div>
                            <div class="item_2">
                                <label><span class="fa fa-map-marker"></span>Dropoff: <b>'.$row['destination_address'].'</b></label>
                                <h6 class="dynamic_data"><span style="font-weight: normal !important">Recipient:</span> '.$row['recepient_name'].'</h6>    
                            </div>
                            <hr class="divider">
                            <div class="item_3">
                                <label><span class="fa fa-user"></span> Driver Name</label>
                                <h6 class="dynamic_data driver-name">'.$driverfname.' '.$driverlname.'</h6>    
                            </div>
                            <div class="item_4">
                                <label><span class="fa fa-sticky-note"></span> Remarks</label>
                                <h6 class="dynamic_data"> '.$note.' </h6>    
                            </div>
                        </div>
                        <div class="orders_wrapper">
                            <div class="order_label">
                                <label>Order ID: <span>#'.$transactionNumber.'</span></label>
                            </div>
                        </div>
                        <div class="signatures_wrapper">
                            <div class="signature_label">
                                <label>Signature</label>
                            </div>
                            <div class="text-muted">
                                <label>'.$imgsig.'</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
';

// $sendmail = sendMail($to,$subject,$message, $imgsig, $imghead);   

// echo $sendmail;

// // Always set content-type when sending HTML email
// $headers = "MIME-Version: 1.0" . "\r\n";
// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// // More headers
// $headers .= 'From:  Yello-X Delivery Report' . "\r\n";

// mail($to,$subject,$message,$headers);   
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From:  Yello-X Delivery Report <noreply@yellox.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);

?>