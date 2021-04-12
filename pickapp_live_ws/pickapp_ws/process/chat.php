<?php
include '../includes/dbconfig2.php';

$headerid = $_REQUEST['headerid'];

$query = "SELECT * from messages where request_header_id = $headerid";
$query = $conn2->query($query);

$update = "UPDATE messages set newmsg = 1 where request_header_id = $headerid and sender_type = 'D'";
$conn2->query($update);

while($row = mysqli_fetch_assoc($query)){
	$json[] = $row;
}

echo json_encode($json);

?>