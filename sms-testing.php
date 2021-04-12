<?php
//header("Access-Control-Allow-Origin: *");
include 'sms/sms_function.php';

    $number = '09228052163';
    $content = "Test message";
    sendSMS($content, $number);


?>