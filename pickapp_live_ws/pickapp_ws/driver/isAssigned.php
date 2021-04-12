<?php
include '../includes/dbconfig2.php';

session_start();
$id = $_SESSION['loginid'];

$query = "SELECT * from request_header where status = 'CONFIRMED' and assigned_driver = $id LIMIT 1";
$query = $conn2->query($query);
$row = mysqli_fetch_assoc($query);
$numrows = mysqli_num_rows($query);

if($numrows > 0){
	echo json_encode($row);
}else{
	echo 0;
}


?>