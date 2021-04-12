<?php
include('includes/dbconfig.php');
include('../ws.yellox.ph/sms/sms_function.php');

$requestorId = $_REQUEST['requestorId'];

$sql = "SELECT * FROM mst_user WHERE id = $requestorId";
$sql = $conn->query($sql);
$row = mysqli_fetch_assoc($sql);
$name = $row['firstname'];
$cellNumber = $row['mobileno'];

$number = '63'.$cellNumber;
$content = "Greetings ".$name." All our drivers are currently booked. Yello-X driver will accept your booking once available. Thank you!";

$send = sendSMS($content, $number);