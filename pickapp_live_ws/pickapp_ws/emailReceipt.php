<?php
session_start();
include 'includes/dbconfig2.php';
$headerid = 290;

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
    $signaturePOST = '<img src="http://pickapp.cssolutions.ph/pickapp_ws/'.$signature.'"/>';
}

$to = 'cssolutionsph@gmail.com';
$subject = "PICKAPP: DELIVERY REPORT #".$transactionNumber;

$message = '<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
    body{
        width: 100%;
    }

        .left{
            color: gray;
            margin-bottom: 0px;
            text-align: right;
            font-size: 12px;
            font-family: arial;
        }

        h2{
            margin-top: 40px;
            text-align: center;
        }

        table#first{
            width: 100%;
            border-bottom: 1px solid gray;
            padding: 10px;
        }

        table#second{
            width: 100%;
            padding: 10px;
        }

        table#third{
            margin-top: 50px;
            width: 100%;
            padding: 10px;
        }

        thead{
            font-size: 14px;
            font-family: arial;
            background-color: #0094da;
            color: white;
            text-align: center;
            vertical-align: center;
        }

        td{
            padding-bottom: 10px;
        }

        .lh{
            color: gray;
        }
        .data{
            font-size: 14px;
            text-align: center;
            font-family: arial;
        }
        .by{
            font-weight: bold;
        }
    </style>
</head>
<body>
<table id="third">
    <tr>
        <td rowspan="2"><img src="http://pickapp.cssolutions.ph/pickapp_ws/dr_header_logo.jpg"/ width="330" height="50"></td>
        <td class="left" align="right">Unit 6 EMT Building Rents, C. Street, Victoria Village,</td>
    </tr>
    <tr>
        <td class="left" align="right">Tabunok, Talisay City, Cebu, Philippines, 6045</td>
    </tr>
</table>

<h2> PICKAPP DELIVERY REPORT </h2>

<table id="first">
    <tr>
        <td class="lh">Transaction Number:</td>
        <td>'.$transactionNumber.'</td>
        <td class="lh">Date and Time Requested:</td>
        <td>'.$row2['dateTime_updated'].'</td>
    </tr>
    <tr>
        <td class="lh">Requested By:</td>
        <td>'.$row3['firstname'].', '.$row3['lastname'].'</td>
        <td class="lh">Date and Time Pick-up:</td>
        <td>'.$row2['dateTime_pick'].'</td>
    </tr>
    <tr>
        <td class="lh">Status:</td>
        <td>'.$row2['status'].'</td>
        <td class="lh">Date and Time Drop-off:</td>
        <td>'.$row2['dateTime_delivered'].'</td>
    </tr>
</table>

<table id="second">
    <thead>
        <td>Item Type</td>
        <td>Description</td>
        <td>Sender</td>
        <td>Pick-up</td>
        <td>Recepient</td>
        <td>Drop-off</td>
        <td>Distance</td>
        <td>Cost</td>
    </thead>
    <tr class="data">
        <td>'.$packageType.'</td>
        <td>'.$row['item'].'</td>
        <td>'.$row['sender_name'].'</td>
        <td>'.$row['origin_address'].'</td>
        <td>'.$row['recepient_name'].'</td>
        <td>'.$row['destination_address'].'</td>
        <td>'.$row['distance'].' km</td>
        <td>PHP '.$row['cost'].'</td>
    </tr>
</table>

<p id="noteH">Note:</p>
<p id="note">" '.$note.' "</p>

<table id="third">
    <tr>
        <td class="lh">Delivered By:</td>
        <td class="lh">Received By:</td>
        <td class="lh">Signature</td>
    </tr>
    <tr>
        <td class="by">'.$driverfname.' '.$driverlname.'</td>
        <td class="by">'.$row2['receivedby'].'</td>
        <td rowspan="10"><img src="http://pickapp.cssolutions.ph/pickapp_ws/'.$signature.'" width="200" height=""></td>
    </tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
    <tr><td></td><td></td><td></td></tr>
</table>

</body>
</html>';


// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From:  info@cssolutions.ph' . "\r\n";
//$headers .= 'Cc: cssolutionsph@gmail.com' . "\r\n";

mail($to,$subject,$message,$headers);   
?>