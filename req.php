<?php
include("includes/dbconfig.php");
$requested_by = $_REQUEST['accountID'];
$status = "PENDING";
$dateTime_requested = date("Y-m-d H:i:s", strtotime('+8 hours'));
$transtype = 1;
$transpoType = 1;
$corporate = 1;

$sql = "INSERT INTO request_header (requested_by, status, dateTime_requested, transtype, transpoType, corporate) VALUES($requested_by, '$status', '$dateTime_requested', $transtype, $transpoType, $corporate)";
$sql = $conn -> query($sql);

if($sql){

	$getID = "SELECT * FROM request_header WHERE requested_by = $requested_by ORDER BY id DESC LIMIT 1";
	$getID = $conn->query($getID);
	$row1 = mysqli_fetch_assoc($getID);

	$idd = $row1['id'];
	$invoice_no = str_pad($idd, 4, '0', STR_PAD_LEFT);

	$insertinvoice = "UPDATE request_header SET invoice_no = '$invoice_no' WHERE requested_by = $requested_by ORDER BY id DESC LIMIT 1";
	$insertinvoice = $conn->query($insertinvoice);
	echo $idd;
}else{
	echo mysqli_error($conn);
}
?>