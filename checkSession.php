<?php

session_start();
include('includes/dbconfig.php');

$id = $_SESSION['id'];

$sql = "SELECT * FROM mst_admin_user WHERE id = $id";
$sql = $conn->query($sql);

if($sql->num_rows>0){
	echo "logging in, please wait...";
	$_SESSION["success"] = "success";
	echo "<script>window.location.replace('dashboard.php')</script>";
}
else{
	echo "checking log in status...";
	$_SESSION["error"] = "error";
	echo "<script>window.location.replace('check.php')</script>";
}

?>