<?php
include '../includes/dbconfig2.php';

session_start();
$loginid = $_SESSION['loginid'];

$query = "SELECT request_header.id, request_details.recepient_name, request_details.recepient_number, request_details.tod, request_details.details_status, request_details.destination_address  FROM request_header INNER JOIN request_details on request_header.id = request_details.request_header_id where (request_header.status = 'ACCEPTED' AND request_details.details_status ='ACCEPTED') AND request_header.assigned_driver = $loginid";
$query = $conn2->query($query);

while($row = mysqli_fetch_assoc($query)){
	$json[] = $row;
}

echo json_encode($json);

?>