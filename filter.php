<?php
include('includes/dbconfig.php');

$drr = $_REQUEST['drr'];
$startDate  = $_REQUEST['startDate'];
$endDate = $_REQUEST['endDate'];
$driverVal = $_REQUEST['driverVal'];
$result = [];
$count = 0;
$status = 'COMPLETED';
$addtionalCommand = '';

mysqli_set_charset( $conn, 'utf8');

if($drr == 1){
	$status = 'COMPLETED';
}else if($drr == 2){
	$status = 'CANCELLED';
}else if($drr == 3){
	$status = 'ACCEPTED';
}

if($startDate != "" && $endDate != "" && $driverVal == 0){
	$addtionalCommand = "dateTime_requested BETWEEN '$startDate' AND '$endDate' AND";
}else if($startDate != "" && $endDate != "" && $driverVal != 0){
	$addtionalCommand = "dateTime_requested BETWEEN '$startDate' AND '$endDate' AND mst_admin_user.id = $driverVal AND";
}else if($startDate == "" && $endDate == "" && $driverVal != 0){
	$addtionalCommand = "mst_admin_user.id = $driverVal AND";
}

$sql  = "SELECT request_header.dateTime_requested, request_header.dateTime_delivered,request_header.requested_by, mst_user.firstname, mst_user.lastname, package_type.package_name, request_details.origin_address, request_details.destination_address, request_details.distance, request_details.cost, mst_admin_user.fname, mst_admin_user.lname FROM request_header LEFT JOIN request_details ON request_header.id = request_details.request_header_id LEFT JOIN mst_user ON request_header.requested_by = mst_user.id LEFT JOIN package_type ON request_details.package_type = package_type.id LEFT JOIN mst_admin_user ON request_header.assigned_driver = mst_admin_user.id WHERE ".$addtionalCommand." request_header.status = '$status' ORDER BY request_header.dateTime_requested DESC";
$sql = $conn->query($sql);
$lineNo = 0;
while($row = mysqli_fetch_assoc($sql)){	
	$lineNo++;
	$requestDate = $row['dateTime_requested'];
	$requestDelivered = $row['dateTime_delivered'];

	$hourdiff = round((strtotime($requestDelivered) - strtotime($requestDate))/3600, 1);
	$hourdiff1 = $hourdiff."Hours / Minutes";
	$name = '<span style="text-transform: capitalize">'.$row['firstname'].' '.$row['lastname'].'</span>';
	$result[$count]['lineNo'] = $lineNo;
	$result[$count]['timeCompleted'] = $hourdiff1;
	$result[$count]['dateDelivered'] = $row['dateTime_delivered'];
	$result[$count]['dateRequested'] = $row['dateTime_requested'];
	$result[$count]['requestedBy'] = $name;
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

echo json_encode(array('data' => $result));

?>