<?php
header("Access-Control-Allow-Origin: *");
include '../includes/dbconfig2.php';
include '../includes/function.php';
include '../../sms/sms_function.php';

$fname = $_REQUEST['fname'];
$mi = $_REQUEST['mi'];
$lname = $_REQUEST['lname'];
$contact = $_REQUEST['contact'];
$email = $_REQUEST['email'];
$username = $_REQUEST['username'];
$password = md5($_REQUEST['password']);
$code = md5($_REQUEST['code']);
$code2 =  $_REQUEST['code'];
$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));

$query = "INSERT into mst_user (firstname, mi, lastname, mobileno, emailadd, username, password, dateTime_created, dateTime_updated, code, status) values ('$fname', '$mi', '$lname', '$contact', '$email', '$username', '$password', '$new_time', '$new_time', '$code', 0)";

$querys = $conn2->query($query);
if(!$querys){
    echo mysqli_error($conn2);
}

$lastid = "SELECT * from mst_user where username = '$username'";
$lastids = $conn2->query($lastid);
$numrows = mysqli_num_rows($lastids);

if($numrows > 0){
	$row = mysqli_fetch_assoc($lastids);
    $date = date("ymds");

    $number = '+63'.$contact;
    $content = "Your Yello-X verification code is ".$code2;
    $send = sendSMS($content, $number);

    echo json_encode($row);
}

?>