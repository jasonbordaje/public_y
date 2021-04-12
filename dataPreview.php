<?php
include('includes/dbconfig.php');
$result = [];
$count = 0;


$sql  = "SELECT request_header.dateTime_requested, request_header.dateTime_delivered,request_header.requested_by, mst_user.firstname, mst_user.lastname, package_type.package_name, request_details.origin_address, request_details.destination_address, request_details.distance, request_details.cost, mst_admin_user.fname, mst_admin_user.lname FROM request_header INNER JOIN request_details ON request_header.id = request_details.request_header_id INNER JOIN mst_user ON request_header.requested_by = mst_user.id INNER JOIN package_type ON request_details.package_type = package_type.id INNER JOIN mst_admin_user ON request_header.assigned_driver = mst_admin_user.id WHERE request_header.status = 'COMPLETED' ORDER BY request_header.dateTime_requested DESC";
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){	

	$requestDate = $row['dateTime_requested'];
	$requestDelivered = $row['dateTime_delivered'];

	$hourdiff = round((strtotime($requestDelivered) - strtotime($requestDate))/3600, 1);
	$hourdiff1 = $hourdiff."Hours / Minutes";
	
	$result[$count]['timeCompleted'] = $hourdiff1;
	$result[$count]['dateDelivered'] = $row['dateTime_delivered'];
	$result[$count]['dateRequested'] = $row['dateTime_requested'];
	$result[$count]['requestedBy'] = $row['firstname'];
	$result[$count]['requestedBy1'] = $row['lastname'];
	$result[$count]['itemRequested'] = $row['package_name'];
	$result[$count]['originAddress'] = $row['origin_address'];
	$result[$count]['destinationAddress'] = $row['destination_address'];
	$result[$count]['distance'] = $row['distance'];
	$result[$count]['cost'] = $row['cost'];
	$result[$count]['driverAssigned'] = $row['fname'];
	$result[$count]['driverAssigned1'] = $row['lname'];


$count++;	
}

echo json_encode($result);
?>