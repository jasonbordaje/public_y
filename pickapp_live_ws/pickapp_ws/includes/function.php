<?php
function checkUsername($username) {
	include 'dbconfig2.php';

	$query = "SELECT id from mst_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	$id = $row['id'];
	
	if ($id > 0) {
		return 1;
	} else {
		return 0;
	}
}

function checkPassword($username) {
	include 'dbconfig2.php';
	
	$query = "SELECT password from mst_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	return $row['password'];
}

function checkStatus($username){
	include 'dbconfig2.php';

	$query = "SELECT status from mst_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	return $row['status'];
}

function getID($username) {
	include 'dbconfig2.php';

	$query = "SELECT id from mst_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_array($query);
	
	return $row['id'];
}

function getCode($username) {
	include 'dbconfig2.php';

	$query = "SELECT code from mst_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_array($query);
	
	return $row['code'];
}

function userInfo($loginid,$field) {
	include 'dbconfig2.php';

	$query = "SELECT $field as ans from mst_user where id = $loginid";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	return $row['ans'];
}

function logtxt($loginid,$log) {
	include 'dbconfig2.php';

	$now = date('Y-m-d H:i:s');
	$query = "INSERT into log(log_desc,dateTime_created,userid) values('$log','$now',$loginid)";
	$conn2->query($query);
}
?>