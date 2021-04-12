<?php
include '../includes/dbconfig2.php';

$email = $_REQUEST['email'];

$query = "SELECT username,id from mst_user where username = '$email'";
$query = $conn2->query($query);
//$count = mysqli_num_rows($query);
$row = mysqli_fetch_array($query);
$id = $row['id'];

if($id > 0){
	echo "TAKEN";
}
else{
	echo "AVAILABLE";
}
?>