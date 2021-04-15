<?php
include('includes/dbconfig.php');

$sql  = "SELECT * FROM locations";
$result = mysqli_query($conn,$sql);
// $result->fetch_all(MYSQLI_ASSOC);
// var_dump(mysqli_free_result($result));
$data = [];
$count = 0;
$increment = 1;
while($row = mysqli_fetch_assoc($result)){
	$data[$count]['count'] = $increment;
	$data[$count]['id'] = $row['id'];
	$data[$count]['location_name'] = $row['name'];
	$data[$count]['location_lat'] = $row['location_lat'];
	$data[$count]['location_long'] = $row['location_long'];
	$count++;
	$increment++;
}

echo json_encode(array('data' => $data));