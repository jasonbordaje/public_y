<?php
include '../includes/dbconfig2.php';

session_start();
$now = date("Y-m-d H:i:s", strtotime('+8 hours'));
$driverid = $_SESSION['loginid'];
$lat = $_REQUEST['lat'];
$long = $_REQUEST['long'];

//$update = "UPDATE driver_availability set location_lat = '$lat', location_long = '$long' where driver_id = $driverid";
$update = "Insert into delivery_tracking(driver_id,request_header_id,location_lat,location_long,dateTime_added) values($driverid,0,'$lat','$long','$now')";
$update = $conn2->query($update);

echo $driverid;
?>