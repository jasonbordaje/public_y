<?php
include('../ws.yellox.ph/sms/sms_function.php');

// $mobile_no = $_REQUEST['mobile_no'];
$mobile_no = "09302999876";
$initial = $_REQUEST['initial'];

$number = '63'.(int)$mobile_no;
$content = "Greetings ".$initial."!";

$send = sendSMS($content, $number);