<?php
include '../includes/dbconfig2.php';

$headerid = $_REQUEST['headerid'];

$query = "SELECT * from request_header where id = $headerid and status = 'ACCEPTED'";
$query = $conn2->query($query);

if($query){

	$result = mysqli_fetch_assoc($query);
	$driverid = $result['assigned_driver'];

	$query2 = "SELECT * from mst_admin_user where id = $driverid";
	$query2 = $conn2->query($query2);
	$row = mysqli_fetch_assoc($query2);
	echo json_encode($row);

}

?>