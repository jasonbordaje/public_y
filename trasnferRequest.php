<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;
$requestHeaderID = $_REQUEST['requestHeaderID'];


$sql = "SELECT  mst_admin_user.avatar, mst_admin_user.id, mst_admin_user.username,driver_availability.is_online, driver_availability.is_available, mst_admin_user.fname, mst_admin_user.lname, mst_admin_user.contact_no, mst_admin_user.licenseno FROM driver_availability INNER JOIN mst_admin_user ON driver_availability.driver_id = mst_admin_user.id WHERE driver_availability.is_available <> 0 OR driver_availability.is_available = 0 AND driver_availability.is_online <> 0 ORDER BY driver_availability.is_online AND driver_availability.is_available  DESC";
$sql = $conn->query($sql);

while($row = mysqli_fetch_assoc($sql)){
	$driverID = $row['id'];

	$query= "SELECT * FROM request_header WHERE id = $requestHeaderID AND assigned_driver = $driverID";
	$query = $conn->query($query);
	$row2 = mysqli_fetch_assoc($query);

	if($query->num_rows>0){
		$row1 = "ongoing";
	}
	else{
		$row1 = "available";
	}

	$result[$count]['id'] = $row['id'];
	$result[$count]['driverStatus'] = $row1;
	$result[$count]['requestID'] = $requestHeaderID;
	$result[$count]['is_online'] = $row['is_online'];
	$result[$count]['is_available'] = $row['is_available'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['lname'] = $row['lname'];
	$result[$count]['contact_no'] = $row['contact_no'];
	$result[$count]['licenseno'] = $row['licenseno'];
	$result[$count]['username'] = $row['username'];
	$result[$count]['avatar'] = $row['avatar'];
	
	$count++;
}

echo json_encode($result);
?>
