<?php

session_start();
include('includes/dbconfig.php');

$id = $_SESSION['id'];

$headerID = $_REQUEST['requestHeaderID'];
$chosendriverID = $_REQUEST['radioTransID'];
$currentdriverID = $_REQUEST['currentDriverID'];
$passtype = md5($_REQUEST['passtype']);

$sql3 = "SELECT * FROM mst_admin_user WHERE id = $id AND password = '$passtype'";
$sql3 = $conn->query($sql3);
if($sql3->num_rows>0){
	$sql = "UPDATE request_header SET assigned_driver = $chosendriverID WHERE id = $headerID";
	$sql = $conn->query($sql);

	if($sql){
		$sql1 = "UPDATE driver_availability SET is_available = 0 WHERE driver_id = $chosendriverID ";
		$sql1 = $conn->query($sql1);

		$sql2 = "UPDATE driver_availability SET is_available = 1 WHERE driver_id = $currentdriverID";
		$sql2 = $conn->query($sql2);

		echo "save";
	}
	else{
		echo mysql_error($conn);
	}
}else{
	echo "error";
}

?>