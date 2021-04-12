<?php

session_start();
include("includes/dbconfig.php");
$id = 5;
$result = [];	
$count = 0;
$driver_id = $_REQUEST['driver_id'];
$sql1 = "UPDATE admin_chat SET newmsg = 0 WHERE receiver_id = $id AND sender_id = $driver_id	";
$sql1 = $conn->query($sql1);

$sql = "SELECT * FROM `admin_chat` WHERE receiver_id = $driver_id AND sender_id = $id OR receiver_id = $id AND sender_id = $driver_id";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){
	$result[$count]['sender_id'] = $row['sender_id'];
	$result[$count]['loginid'] = $id;
	$result[$count]['message'] = $row['message'];
	$result[$count]['dateTime_sent'] = $row['dateTime_sent'];
	$result[$count]['newmsg'] = $row['newmsg'];
	$count++;
}

echo json_encode($result);
?>