<?php

include("includes/dbconfig.php");
$result = [];
$count = 0;

$sql = "SELECT * FROM mst_user WHERE corporate = 1";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){
	$result[$count]["id"] = $row['id'];
	$result[$count]["firstname"] = $row['firstname'];
	$result[$count]["mi"] = $row['mi'];
	$result[$count]["lastname"] = $row['lastname'];
	$result[$count]["mobileno"] = $row['mobileno'];
	$count++;
}

echo json_encode($result);
?>