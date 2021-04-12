<?php
include '../includes/dbconfig2.php';

session_start();

$message = $_REQUEST['message'];
$loginid = $_SESSION['loginid'];
$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));


$query = "INSERT into admin_chat (message, sender_id, receiver_id, sender_type, dateTime_sent) values ('$message', $loginid, 5, 'D', '$new_time')";
$query = $conn2->query($query);

if($query){
	echo "OK";
}

?>