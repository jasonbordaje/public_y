<?php
include('includes/dbconfig.php');

$page = $_REQUEST['page'];
$record_per_page = 10;
$start_from = ($page-1)*$record_per_page;
$result1 = [];
$count  = 0;

$query = "SELECT * FROM request_header ORDER BY id DESC LIMIT $start_from, $record_per_page";
$result = $conn->query($query);

while($row = mysqli_fetch_assoc($result)){
	$result1[$count]['id'] = $row['id'];
	$result1[$count]['status'] = $row['status'];

$count++;
}

echo json_encode($result1);

?>