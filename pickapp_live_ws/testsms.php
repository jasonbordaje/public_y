<?php
include 'sms/sms_function.php';

$number = "09302999876";
$content = "Test";
$send = sendSMS($content, $number);
?>