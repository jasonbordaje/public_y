<?php

session_start();
include("includes/dbconfig.php");
$id = $_SESSION['id'];
$result = [];
$count = 0;
$sql = "SELECT mst_admin_user.id, mst_admin_user.fname, mst_admin_user.lname, mst_admin_user.avatar, driver_availability.is_online, driver_availability.is_available FROM mst_admin_user LEFT JOIN driver_availability ON mst_admin_user.id = driver_availability.driver_id  WHERE user_type = 2";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){
	$drivers_id = $row['id'];
	$sql1 = "SELECT * FROM (SELECT * FROM admin_chat WHERE receiver_id = $drivers_id OR sender_id = $drivers_id ORDER BY id DESC) AS x GROUP BY sender_id ORDER BY id DESC LIMIT 1 ";
	$sql1 = $conn->query($sql1);
	$row1 = mysqli_fetch_assoc($sql1);

	$result[$count]['messageId'] = $row1['id'];
	$result[$count]['message'] = $row1['message'];
	$result[$count]['sender_id'] = $row1['sender_id'];
	$result[$count]['login_id'] = $id;
	$result[$count]['driver_id'] = $row['id'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['lname'] = $row['lname'];
	$result[$count]['avatar'] = $row['avatar'];
	$result[$count]['is_online'] = $row['is_online'];
	$result[$count]['is_available'] = $row['is_available'];
	$count++;
}

echo json_encode($result);
?>