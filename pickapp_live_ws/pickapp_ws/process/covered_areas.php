<?php
include '../includes/dbconfig2.php';

$query = "SELECT * from covered_areas where status = 'UP'";
$query = $conn2->query($query);
$result = '';
$count = 0;

while($row = mysqli_fetch_assoc($query)){
	$result[$count]['area'] .= $row['area'];
	$count++;
}

echo json_encode($result);
?>