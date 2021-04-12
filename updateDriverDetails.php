<?php
include('includes/dbconfig.php');

$id = $_REQUEST['id'];
$name = $_REQUEST['name'];
$identifier = $_REQUEST['identifier'];

if($identifier == "fname"){
	$sql = "UPDATE mst_admin_user SET fname = '$name' WHERE id = $id";
	$sql = $conn->query($sql);
	if($sql){
		echo "updated";
	}
}else if($identifier == "lname"){
	$sql = "UPDATE mst_admin_user SET lname = '$name' WHERE id = $id";
	$sql = $conn->query($sql);
	if($sql){
		echo "updated";
	}
}else if($identifier == "contact"){
	$sql = "UPDATE mst_admin_user SET contact_no = '$name' WHERE id = $id";
	$sql = $conn->query($sql);
	if($sql){
		echo "updated";
	}
}else if($identifier == "emailadd"){
	$sql = "UPDATE mst_admin_user SET email_add = '$name' WHERE id = $id";
	$sql = $conn->query($sql);
	if($sql){
		echo "updated";
	}
}else if($identifier == "license"){
	$sql = "UPDATE mst_admin_user SET licenseno = '$name' WHERE id = $id";
	$sql = $conn->query($sql);
	if($sql){
		echo "updated";
	}
}else if($identifier == "api"){
	$sql = "UPDATE mst_admin_user SET google_api_key = '$name' WHERE id = $id";
	$sql = $conn->query($sql);
	if($sql){
		echo "updated";
	}
}

?>