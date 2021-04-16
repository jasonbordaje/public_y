<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;
mysqli_set_charset( $conn, 'utf8');

$locationIndexLat = $_SESSION['location_index'];
$locationIndexLng = $_SESSION['user']['location_long'];
// $sql = "SELECT request_header.assigned_driver,mst_admin_user.fname ,request_header.invoice_no, request_header.id , request_header.at_pickup,request_header.at_dropoff,mst_user.firstname, mst_user.lastname, request_details.item, package_type.package_name, request_details.sender_name, request_details.sender_contact, request_details.recepient_name, request_details.recepient_number, request_details.origin_lat, request_details.origin_lng, request_details.destination_lat, request_details.destination_lng , request_details.origin_address, request_details.destination_address, request_details.distance, request_details.cost, request_details.note, request_header.status, request_details.tod FROM request_details LEFT JOIN request_header ON request_header.id = request_details.request_header_id LEFT JOIN mst_user ON request_header.requested_by = mst_user.id  LEFT JOIN package_type ON request_details.package_type = package_type.id LEFT JOIN mst_admin_user ON request_header.assigned_driver = mst_admin_user.id WHERE request_header.status = 'CONFIRMED' OR request_header.status = 'ACCEPTED' ORDER BY request_header.id ASC";
if ($_SESSION['user']['user_type'] == 1) {
	$sql = "SELECT request_header.assigned_driver,mst_admin_user.fname ,request_header.invoice_no, request_header.id , request_header.at_pickup,request_header.at_dropoff,mst_user.firstname, mst_user.lastname, request_details.item, package_type.package_name, request_details.sender_name, request_details.sender_contact, request_details.recepient_name, request_details.recepient_number, request_details.origin_lat, request_details.origin_lng, request_details.destination_lat, request_details.destination_lng , request_details.origin_address, request_details.destination_address, request_details.distance, request_details.cost, request_details.note, request_header.status, request_details.tod, request_header.requested_by FROM request_details LEFT JOIN request_header ON request_header.id = request_details.request_header_id LEFT JOIN mst_user ON request_header.requested_by = mst_user.id  LEFT JOIN package_type ON request_details.package_type = package_type.id LEFT JOIN mst_admin_user ON request_header.assigned_driver = mst_admin_user.id WHERE (request_header.status = 'CONFIRMED' OR request_header.status = 'ACCEPTED') AND (request_details.details_status = 'CONFIRMED' or request_details.details_status = 'ACCEPTED') GROUP BY request_header.id ORDER BY request_header.id ASC";
}else{
	$sql = "SELECT SUBSTRING_INDEX(request_details.origin_lat, '.', 1) as location_lat, SUBSTRING_INDEX(request_details.origin_lng, '.', 1) as location_lng, request_header.assigned_driver,mst_admin_user.fname ,request_header.invoice_no, request_header.id , request_header.at_pickup,request_header.at_dropoff,mst_user.firstname, mst_user.lastname, request_details.item, package_type.package_name, request_details.sender_name, request_details.sender_contact, request_details.recepient_name, request_details.recepient_number, request_details.origin_lat, request_details.origin_lng, request_details.destination_lat, request_details.destination_lng , request_details.origin_address, request_details.destination_address, request_details.distance, request_details.cost, request_details.note, request_header.status, request_details.tod, request_header.requested_by FROM request_details LEFT JOIN request_header ON request_header.id = request_details.request_header_id LEFT JOIN mst_user ON request_header.requested_by = mst_user.id  LEFT JOIN package_type ON request_details.package_type = package_type.id LEFT JOIN mst_admin_user ON request_header.assigned_driver = mst_admin_user.id WHERE (request_header.status = 'CONFIRMED' OR request_header.status = 'ACCEPTED') AND (request_details.details_status = 'CONFIRMED' or request_details.details_status = 'ACCEPTED') GROUP BY request_header.id ORDER BY request_header.id ASC";
}
$sql = $conn->query($sql);
while($row = mysqli_fetch_assoc($sql)){


	$result[$count]['id'] = $row['id'];
	$result[$count]['driverid'] = $row['assigned_driver'];
	$result[$count]['at_pickup'] = $row['at_pickup'];
	$result[$count]['at_dropoff'] = $row['at_dropoff'];
	$result[$count]['fname'] = $row['fname'];
	$result[$count]['firstname'] = $row['firstname'];
	$result[$count]['lastname'] = $row['lastname'];
	$result[$count]['item'] = $row['item'];
	$result[$count]['package_name'] = $row['package_name'];	
	$result[$count]['sender_name'] = $row['sender_name'];
	$result[$count]['sender_contact'] = $row['sender_contact'];
	$result[$count]['recepient_name'] = $row['recepient_name'];
	$result[$count]['recepient_number'] = $row['recepient_number'];
	$result[$count]['origin_lat'] = $row['origin_lat'];
	$result[$count]['origin_lng'] = $row['origin_lng'];
	$result[$count]['destination_lat'] = $row['destination_lat'];
	$result[$count]['destination_lng'] = $row['destination_lng'];
	$result[$count]['origin_address'] = $row['origin_address'];
	$result[$count]['destination_address'] = $row['destination_address'];
	$result[$count]['distance'] = $row['distance'];
	$result[$count]['cost'] = $row['cost'];
	$result[$count]['note'] = $row['note'];
	$result[$count]['status'] = $row['status'];
	$result[$count]['requested_by'] = $row['requested_by'];
	$result[$count]['tod'] = $row['tod'];


	$count++;
}

echo json_encode($result);
?>