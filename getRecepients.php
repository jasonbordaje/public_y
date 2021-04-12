<?php
include("includes/dbconfig.php");
$tr = $_REQUEST["tr"];
$result = [];
$count = 0;

$getRecep = "SELECT  DISTINCT(recepient_name), recepient_number  FROM request_details WHERE sender_name = '$tr' ORDER BY `id`  DESC ";
$getRecep = $conn->query($getRecep);

while($row = mysqli_fetch_assoc($getRecep)){
	$result[$count]['recepient_name'] = $row['recepient_name'];
	$result[$count]['recepient_number'] = $row['recepient_number'];
	$count++;
}

echo json_encode($result);
?>