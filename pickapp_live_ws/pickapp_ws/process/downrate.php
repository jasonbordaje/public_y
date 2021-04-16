<?php
include '../includes/dbconfig2.php';
$locationLat = $_REQUEST['location_latitude'];
$locationLng = $_REQUEST['location_longitude'];

$locationLatIndex = explode(".",$locationLat,2);
$locationLatIndex = (int)$locationLatIndex[0];

$locationLngIndex = explode(".",$locationLng,2);
$locationLngIndex = (int)$locationLngIndex[0];

// var_dump($locationLatIndex);
$getLocation = "SELECT * FROM locations WHERE location_lat = $locationLatIndex AND location_long = $locationLngIndex LIMIT 1";

$getLocation = $conn2->query($getLocation);
$getLocation = mysqli_fetch_assoc($getLocation);
$locationId = $getLocation['id'];

$query = "SELECT * FROM rate WHERE location_id = $locationId LIMIT 1";
$query = $conn2->query($query);

$row = mysqli_fetch_assoc($query);

echo $row['rate'];

?>