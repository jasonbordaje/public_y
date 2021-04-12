<?php
include '../includes/dbconfig2.php';

$id = $_REQUEST['id'];

$query = "UPDATE notifications SET status = 0 WHERE id = $id";
$query = $conn2->query($query);

if($query){
	echo 'updated';
}else{
	echo 'no update.';
}


?>