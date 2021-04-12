<?php
include("includes/dbconfig.php");
$result = [];
$count = 0;
$startDate = $_REQUEST['start11'];
$endDate = $_REQUEST['end11'];
$searchFilter = $_REQUEST['searchFilter'];
mysqli_set_charset( $conn, 'utf8');
if($searchFilter == 1){
$sql = "SELECT log.log_desc, log.dateTime_created, log.requestid, mst_admin_user.fname, mst_admin_user.lname FROM log LEFT JOIN mst_admin_user ON log.userid = mst_admin_user.id ORDER BY log.id DESC";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){
	$requestid = $row['requestid'];

	$sql1 = "SELECT requested_by FROM request_header WHERE id = $requestid";
	$sql1 = $conn->query($sql1);
	$row1 = mysqli_fetch_assoc($sql1);
	$requested_by = $row1['requested_by'];

	$sql2 = "SELECT firstname, lastname FROM mst_user WHERE id = $requested_by";
	$sql2 = $conn->query($sql2);
	$row2 = mysqli_fetch_assoc($sql2);

	$result[$count]['log_desc'] = $row['log_desc'];
	$result[$count]['dateTime_created'] = $row['dateTime_created'];
	$result[$count]['firstname'] = $row2['firstname'];
	$result[$count]['lastname'] = $row2['lastname'];
	$result[$count]['requestid'] = $row['requestid'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['lname'] = $row['lname'];
	$count++;
}

echo json_encode($result);
}else if($searchFilter == 2){
$sql = "SELECT log.log_desc, log.dateTime_created, log.requestid, mst_admin_user.fname, mst_admin_user.lname FROM log LEFT JOIN mst_admin_user ON log.userid = mst_admin_user.id WHERE log.dateTime_created BETWEEN '$startDate' AND '$endDate' ORDER BY log.id DESC";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){
	$requestid = $row['requestid'];

	$sql1 = "SELECT requested_by FROM request_header WHERE id = $requestid";
	$sql1 = $conn->query($sql1);
	$row1 = mysqli_fetch_assoc($sql1);
	$requested_by = $row1['requested_by'];

	$sql2 = "SELECT firstname, lastname FROM mst_user WHERE id = $requested_by";
	$sql2 = $conn->query($sql2);
	$row2 = mysqli_fetch_assoc($sql2);

	$result[$count]['log_desc'] = $row['log_desc'];
	$result[$count]['dateTime_created'] = $row['dateTime_created'];
	$result[$count]['firstname'] = $row2['firstname'];
	$result[$count]['lastname'] = $row2['lastname'];
	$result[$count]['requestid'] = $row['requestid'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['lname'] = $row['lname'];
	$count++;
}

echo json_encode($result);
}

?>