<?php

include("includes/dbconfig.php");
header('Access-Control-Allow-Origin: *');

$headerid = 1128;
$toemail = "modernpetalscebu@gmail.com";
$firstname = "modern petals";
$lastname = "cebu";
$dateTime_requested = "2018-02-12 16:33:24";
$dateTime_pick = "2018-02-13 10:09:23";
$transactionNumber = $s_number = str_pad( $headerid, 4, "0", STR_PAD_LEFT );
$dateTime_delivered = date('Y-m-d H:i:s', strtotime('+8 hours'));
$receivedBy = "Jeanette D.Magallano";
$dest = " 352 burgosst.alang-alang,mandaue city cebu";
$dist = "13.8";
$cost = "198.00";
$driverfname = "Darwin";
$driverlname = "Macaseren";

if(!$signature){
    $signaturePOST = 'No signature found.';
}else{
    $signaturePOST = '<img src="http://pickapp.cssolutions.ph/pickapp_ws/'.$signature.'"/>';
}

$to = $toemail;
$subject = "PickApp: Delivery Report #".$transactionNumber;

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
        <td>'.$dateTime_requested.'</td>
    </tr>
    <tr>
        <td class="lh">Requested By:</td>
        <td>'.$firstname.', '.$lastname.'</td>
        <td class="lh">Date and Time Pick-up:</td>
        <td>'.$dateTime_pick.'</td>
    </tr>
    <tr>
        <td class="lh">Status:</td>
        <td>COMPLETED</td>
        <td class="lh">Date and Time Drop-off:</td>
        <td>'.$dateTime_delivered.'</td>
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
        <td>Flower</td>
        <td>Flower</td>
        <td>Modern Petals Cebu</td>
        <td>2 Mohon Road, Cebu City, Cebu, Philippines </td>
        <td>'.$receivedBy.'</td>
        <td>'.$dest.'</td>
        <td>'.$dist.' km</td>
        <td>PHP '.$cost.'</td>
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
        <td class="by">'.$receivedBy.'</td>
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