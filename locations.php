<?php
include('includes/dbconfig.php');

$sql  = "SELECT loc.id, loc.name, loc.location_lat, loc.location_long, rate.rate FROM locations as loc LEFT JOIN rate ON loc.id = rate.location_id";
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
	$data[$count]['rate'] = $row['rate'];
	$count++;
	$increment++;

	//insert rate per location
	// $a = $row['id'];
	// if ($a == 40) {
	// 	$rateAmount = 60;
	// }else{
	// 	$rateAmount = 0;
	// }
	// $rate = "INSERT INTO rate (rate,location_id) VALUES ($rateAmount,$a)";
	// mysqli_query($conn,$rate);
}

echo json_encode(array('data' => $data));