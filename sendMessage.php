<?php

session_start();
include("includes/dbconfig.php");
$id = 5;
$driver_id = $_REQUEST['driver_id'];
$message = $_REQUEST['message'];
$dateTime_sent = date('Y-m-d H:i:s', strtotime('+8 hours'));

$sql = "INSERT INTO admin_chat (message, receiver_id, sender_id, dateTime_sent, newmsg, sender_type) VALUES('$message', $driver_id, $id, '$dateTime_sent', 1, 'A')";
$sql = $conn->query($sql);

if(!$sql){
	echo mysqli_error($conn);
}else{
	echo "sent";
}

?>