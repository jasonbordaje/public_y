<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;

$sql = "SELECT mst_admin_user.id, mst_admin_user.fname, mst_admin_user.lname, mst_admin_user.avatar, driver_availability.location_lat, driver_availability.location_long FROM mst_admin_user LEFT JOIN driver_availability ON mst_admin_user.id = driver_availability.driver_id WHERE driver_availability.is_online = 1 AND driver_availability.is_available = 1";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){
	$result[$count]['id'] = $row['id'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['lname'] = $row['lname'];
	$result[$count]['avatar'] = $row['avatar'];
	$result[$count]['location_lat'] = $row['location_lat'];
	$result[$count]['location_long'] = $row['location_long'];

	$count++;
}

echo json_encode($result);
?>