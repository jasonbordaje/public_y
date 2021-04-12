<?php

session_start();
include('includes/dbconfig.php');
$id = $_SESSION['id'];

$adminPass1 = $_REQUEST['adminPass1'];
$statusName = $_REQUEST['statusName'];
$encPass = md5($adminPass1);
$requestID = $_REQUEST['requestID'];
$createdate= date('Y-m-d H:i:s', strtotime('+8 hours'));

echo $adminPass1." ".$statusName." ".$requestID;

if($statusName == "ongoing"){

$sql1 = "SELECT * FROM mst_admin_user WHERE id = $id AND password = '$encPass' ";
$sql1 = $conn->query($sql1);

if($sql1->num_rows>0){
$sql2 = "SELECT * FROM request_header WHERE id = $requestID";
$sql2 = $conn->query($sql2);
$row = mysqli_fetch_assoc($sql2);
$assigned_Driver = $row['assigned_driver'];

$sql3 = "UPDATE driver_availability SET is_available = 1 WHERE driver_id = $assigned_Driver";
$sql3 = $conn->query($sql3);

$sql = "UPDATE request_header SET status = 'CANCELLED' WHERE id = $requestID";
$sql = $conn->query($sql);
	//add this
	$sql10 = "SELECT * FROM log WHERE requestid = $requestID AND userid = $id AND log_desc = 'ONGOING REQUEST CANCELLED' ";
	$sql10 = $conn->query($sql10);

	//new
	if($sql10->num_rows>0){
	}else{
	$sql8 = "INSERT INTO log(log_desc, dateTime_created, requestid, userid) VALUES('ONGOING REQUEST CANCELLED', '$createdate', $requestID, $id)";
	$sql8 = $conn->query($sql8);
	}
echo "updated!";
}
else{
	echo "error";
}
}
else if($statusName == "confirmed"){
	$sql1 = "SELECT * FROM mst_admin_user WHERE id = $id AND password = '$encPass' ";
$sql1 = $conn->query($sql1);

if($sql1->num_rows>0){
$sql = "UPDATE request_header SET status = 'CANCELLED' WHERE id = $requestID";
$sql = $conn->query($sql);
	//add this
	$sql9 = "SELECT * FROM log WHERE requestid = $requestID AND userid = $id AND log_desc = 'CONFIRMED REQUEST CANCELLED'";
	$sql9 = $conn->query($sql9);

	$sql7 = "INSERT INTO log(log_desc, dateTime_created, requestid, userid) VALUES('CONFIRMED REQUEST CANCELLED', '$createdate', $requestID, $id)";
	$sql7 = $conn->query($sql7);

	echo "updated!";
}
else{
	echo "error";
}
}



?>