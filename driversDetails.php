<?php

session_start();
include('includes/dbconfig.php');
$id = 5;
$result = [];
$count = 0;
$msgCount;

mysqli_set_charset( $conn, 'utf8');

$sql = "SELECT  mst_admin_user.balance, mst_admin_user.avatar, mst_admin_user.id, mst_admin_user.username,driver_availability.is_online, driver_availability.is_available, mst_admin_user.fname, mst_admin_user.contact_no, mst_admin_user.licenseno FROM driver_availability LEFT JOIN mst_admin_user ON driver_availability.driver_id = mst_admin_user.id WHERE mst_admin_user.user_type = 2 ORDER BY driver_availability.is_online OR driver_availability.is_available  DESC";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){
	$driver_id = $row['id'];

	$sql1 = "SELECT COUNT(receiver_id) as totalMsg, newmsg FROM admin_chat WHERE receiver_id = 5 AND sender_id = $driver_id AND newmsg = 1";
	$sql1 = $conn->query($sql1);
	$row1 = mysqli_fetch_assoc($sql1);
	$msgCount = $row1['totalMsg'];

	$result[$count]['msgCount'] = $msgCount;
	$result[$count]['newmsg'] = $row1['newmsg'];
	$result[$count]['id'] = $row['id'];
	$result[$count]['balance'] = $row['balance'];
	$result[$count]['is_online'] = $row['is_online'];
	$result[$count]['is_available'] = $row['is_available'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['contact_no'] = $row['contact_no'];
	$result[$count]['licenseno'] = $row['licenseno'];
	$result[$count]['username'] = $row['username'];
	$result[$count]['avatar'] = $row['avatar'];
	
	$count++;
}

echo json_encode($result);
?>