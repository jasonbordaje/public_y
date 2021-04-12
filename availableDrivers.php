<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;
$IDRequest1 = $_REQUEST['IDRequest1'];

$sql = "SELECT mst_admin_user.avatar, mst_admin_user.id, mst_admin_user.username,driver_availability.is_online, driver_availability.is_available, mst_admin_user.fname, mst_admin_user.lname, mst_admin_user.contact_no, mst_admin_user.licenseno FROM driver_availability INNER JOIN mst_admin_user ON driver_availability.driver_id = mst_admin_user.id WHERE (driver_availability.is_available = 1 OR driver_availability.is_available = 0 AND driver_availability.is_online = 1) AND mst_admin_user.user_type = 2 ORDER BY driver_availability.is_online AND driver_availability.is_available  DESC";
$sql = $conn->query($sql);

while($row = mysqli_fetch_assoc($sql)){
$driverID = $row['id'];

	$sql1 = "SELECT * FROM request_ledger WHERE request_header_id = $IDRequest1 AND driver_id = $driverID";
	$sql1 = $conn->query($sql1);
	$row1 = mysqli_fetch_assoc($sql1);

	$result[$count]['id'] = $row['id'];
	$result[$count]['is_online'] = $row['is_online'];
	$result[$count]['is_available'] = $row['is_available'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['lname'] = $row['lname'];
	$result[$count]['contact_no'] = $row['contact_no'];
	$result[$count]['licenseno'] = $row['licenseno'];
	$result[$count]['username'] = $row['username'];
	$result[$count]['avatar'] = $row['avatar'];
	$result[$count]['declinedStatus'] = $row1['isDeclined'];
	$result[$count]['declinedBy'] = $row1['declined_by'];
	
	$count++;
}

echo json_encode($result);
?>