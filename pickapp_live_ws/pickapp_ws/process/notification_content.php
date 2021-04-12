<?php
include '../includes/dbconfig2.php';

session_start();
$loginid = $_SESSION['loginid'];
$id = $_REQUEST['id'];

$getname = "SELECT firstname from mst_user where id = $loginid";
$getname = $conn2->query($getname);
$rw = mysqli_fetch_assoc($getname);

$name = $rw['firstname'];

$query = "SELECT * from notifications where id = $id";
$query = $conn2->query($query);
$numrows = mysqli_num_rows($query);
$count = 0;

if($numrows > 0){
	$result = [];
	while($row = mysqli_fetch_assoc($query)){
		$ddate = date('M j', strtotime($row['message_dateTime']));
		$result[$count]['name'] .= $name;
		$result[$count]['title'] .= $row['message_title'];
		$result[$count]['message'] .= $row['message'];
		$result[$count]['message_date'] = $ddate;
		$result[$count]['status'] .= $row['status']; 
		$count++;
	}

	echo json_encode($result);
}else{
	echo "No notifications";
}




?>