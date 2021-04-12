<?php
session_start();
include('includes/dbconfig.php');
include('../ws.yellox.ph/sms/sms_function.php');
$id = $_SESSION['id'];
$driverID = $_REQUEST['driverID'];
$passIDRequest = $_REQUEST['passIDRequest'];
$createdate= date('Y-m-d H:i:s', strtotime('+8 hours'));
mysqli_set_charset( $conn, 'utf8');
ob_end_clean();

$getnumber = "SELECT contact_no, fname, lname FROM mst_admin_user WHERE id = $driverID";
$getnumber = $conn->query($getnumber);
$getnumber_result = mysqli_fetch_assoc($getnumber);
$contact_no = $getnumber_result["contact_no"];
$fname = $getnumber_result["fname"];
$lname = $getnumber_result["lname"];
$number = '63'.(int)$contact_no;
$message = "Hey ".$fname." ".$lname." a request has been assigned to you, please open your Driver app for details.";
$send = sendSMS($message, $number);

$sql2 = "SELECT * FROM request_ledger WHERE request_header_id = $passIDRequest AND driver_id = $driverID AND isDeclined = 1 AND declined_by = 'DRIVER' ";
$sql2 = $conn->query($sql2);
if($sql2->num_rows>0){
	echo "Error";
}
else{

$sql5 = "SELECT * FROM request_ledger WHERE request_header_id = $passIDRequest AND driver_id = $driverID AND declined_by = 'SYSTEM'";	
$sql5 = $conn->query($sql5);

if($sql5->num_rows>0){
	$sql3 = "UPDATE request_ledger SET declined_by = '', isDeclined = 0 WHERE driver_id = $driverID AND request_header_id = $passIDRequest ";
	$sql3 = $conn->query($sql3);

	$sql6 = "UPDATE request_header SET assigned_driver = $driverID WHERE id = $passIDRequest";
	$sql6 = $conn->query($sql6);
}
else{

$sql4 = "SELECT * FROM request_ledger WHERE request_header_id = $passIDRequest AND driver_id = $driverID";	
$sql4 = $conn->query($sql4);

if($sql4->num_rows>0){
	echo "ongoing";
}else{
	$sql = "UPDATE request_header SET assigned_driver = $driverID WHERE id = $passIDRequest";
	$sql = $conn->query($sql);


	$sql1 = "INSERT INTO request_ledger (request_header_id, driver_id, dateTime_added) VALUES($passIDRequest, $driverID, '$createdate')";
	$sql1 = $conn->query($sql1);
	if(!$sql1){
		echo mysqli_error($conn);
	}

	$sql8 = "SELECT * FROM mst_admin_user WHERE user_type = 2 AND id = $driverID";
	$sql8 = $conn->query($sql8);
	$row = mysqli_fetch_assoc($sql8);
	$assignDriver = "Assign Driver ".$row['fname'];

	$sql7 = "INSERT INTO log(log_desc, dateTime_created, requestid, userid) VALUES('$assignDriver', '$createdate', $passIDRequest, $id)";
	$sql7 = $conn->query($sql7);

	if(!$sql7){
		echo mysqli_error($conn);
	}

	if($conn){
		echo "save";
	}
}
	
}
	
}



?>