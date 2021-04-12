<?php
include '../includes/dbconfig2.php';
include '../../sms/sms_function.php';

$username = $_REQUEST['username'];
$code = md5($_REQUEST['code']);
$code2 = $_REQUEST['code'];

$update = "UPDATE mst_user set code = '$code' where username = '$username'";
$conn2->query($update);

$query = "SELECT * FROM mst_user where username = '$username'";
$query = $conn2->query($query);
$row = mysqli_fetch_assoc($query);

$contact = $row['mobileno'];

$date = date("ymds");

$number = $contact;
$content = "Your Yello-X mobile verification code is ".$code2;
$send = sendSMS($content, $number);

echo "SENT";
?>