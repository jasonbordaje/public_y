<?php
include '../includes/dbconfig2.php';

session_start();

$username = $_REQUEST['username'];
$code = md5($_REQUEST['code']);

$query = "SELECT * FROM mst_user where username = '$username'";
$query = $conn2->query($query);

$row = mysqli_fetch_assoc($query);

if($code == $row['code']){

	$_SESSION['loginid'] = $row['id'];

	$update = "UPDATE mst_user set status = 1 where username = '$username'";
	$conn2->query($update);


	echo "GOOD";
}else{
	echo "BAD";
}



?>