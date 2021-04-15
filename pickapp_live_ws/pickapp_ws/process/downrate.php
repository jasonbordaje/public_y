<?php
include '../includes/dbconfig2.php';
$location = $_REQUEST['location_latitude'];
$locationIndex = explode(".",$location,2);
$locationIndex = (int)$locationIndex[0];

$getLocation = "SELECT * FROM locations WHERE location_lat = $locationIndex LIMIT 1";
$getLocation = $conn2->query($getLocation);
$getLocation = mysqli_fetch_assoc($getLocation);
$locationId = $getLocation['id'];

$query = "SELECT * FROM rate WHERE location_id = $locationId LIMIT 1";
$query = $conn2->query($query);

$row = mysqli_fetch_assoc($query);

echo $row['rate'];

?>