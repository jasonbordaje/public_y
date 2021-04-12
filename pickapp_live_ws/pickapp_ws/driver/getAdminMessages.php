<?php
include '../includes/dbconfig2.php';

session_start();
$loginid = $_SESSION['loginid'];

$query = "SELECT * from admin_chat where receiver_id = $loginid OR sender_id = $loginid";
$query = $conn2->query($query);

$update = "UPDATE admin_chat set newmsg = 0 where receiver_id = $loginid";
$conn2->query($update);

while($row = mysqli_fetch_assoc($query)){
	$json[] = $row;
}

echo json_encode($json);

?>