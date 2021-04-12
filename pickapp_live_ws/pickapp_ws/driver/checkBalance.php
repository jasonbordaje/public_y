<?php
include '../includes/dbconfig2.php';

session_start();
$loginid = $_SESSION['loginid'];
$headerid = $_REQUEST['headerid'];
$newTime = date("Y-m-d H:i:s", strtotime('+8 hours'));


$queryBalance = "SELECT balance from mst_admin_user where id = $loginid";
$queryBalance = $conn2->query($queryBalance);
$row = mysqli_fetch_assoc($queryBalance);

$myBalance = $row['balance'];

$queryCost = "SELECT cost from request_details where request_header_id = $headerid";
$queryCost = $conn2->query($queryCost);
$row2 = mysqli_fetch_assoc($queryCost);

$totalCost = $row2['cost'];

$comm = $totalCost * .3;
$result = [];
if($myBalance > $comm){
	$result['status'] = "OK";
	$result['val'] = $myBalance - $comm;
	echo json_encode($result);
}else{
	$query = "UPDATE request_header set assigned_driver = 0 where id = $headerid";
	$query = $conn2->query($query);

	$update = "UPDATE request_ledger set declined_by = 'SYSTEM', isDeclined = 1, dateTime_updated = '$newTime' where request_header_id = $headerid and  driver_id = $loginid";
	$conn2->query($update);

	echo "NO";
}

	
?>