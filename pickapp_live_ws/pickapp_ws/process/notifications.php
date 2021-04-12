<?php
include '../includes/dbconfig2.php';

session_start();
$loginid = $_SESSION['loginid'];

$query = "SELECT * from notifications where user_id = $loginid ORDER BY id DESC";
$query = $conn2->query($query);
$numrows = mysqli_num_rows($query);
$count = 0;

if($numrows > 0){
	$result = [];
	while($row = mysqli_fetch_assoc($query)){
		$ddate = date('M j', strtotime($row['message_dateTime']));
		$result[$count]['id'] .= $row['id'];
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