<?php
include '../includes/dbconfig2.php';

session_start();

$headerid = $_REQUEST['headerid'];
$message = $_REQUEST['message'];
$loginid = $_SESSION['loginid'];
$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));


$query = "INSERT into messages (message, request_header_id, sent_by_id, sender_type, dateTime_sent) values ('$message', $headerid, $loginid, 'U', '$new_time')";
$query = $conn2->query($query);

if($query){
	echo "OK";
}else{
	echo mysqli_error($conn2);
}

?>