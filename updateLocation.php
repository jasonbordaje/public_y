<?php
session_start();
$id = $_SESSION['id'];
error_reporting(0);
$successSession = $_SESSION["success"];
$errorSession = $_SESSION["error"];
include('includes/dbconfig.php');

$locationLat = $_REQUEST['location_lat'];
$locationLong = $_REQUEST['location_long'];
$rate = $_REQUEST['rate'];
$id = $_REQUEST['id'];

$query = "UPDATE locations SET location_lat = $locationLat, location_long = $locationLong WHERE id = $id";
$queryRate = "UPDATE rate SET rate = $rate WHERE location_id = $id";

if($conn->query($query) === true && $conn->query($queryRate)){
	echo 'Sucessfully Updated.';
}else{
	echo 'Something went Wrong!';
}

