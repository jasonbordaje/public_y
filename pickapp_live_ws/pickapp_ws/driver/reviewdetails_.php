<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';

$headerid = $_REQUEST['headerid'];

if (empty($headerid)) {
	session_start();
	$headerid = $_SESSION['headerid'];
}

$query2 = "SELECT DISTINCT a.id as rdid, a.sender_name, a.distance, a.cost, a.origin_address, a.destination_address, a.item, a.recepient_name, d.package_name, b.location_lat, b.location_long, a.note FROM request_details a, delivery_tracking b, request_header c, package_type d WHERE a.request_header_id = $headerid AND c.id = $headerid AND d.id = a.package_type AND (a.details_status = 'ACCEPTED' OR a.details_status = 'CONFIRMED') LIMIT 0,1";

$query2 = $conn2->query($query2);
$numrows = mysqli_num_rows($query2);

if($numrows > 0){
	// if($numrows > 1){
		$res = [];
		$row2 = mysqli_fetch_assoc($query2);
		$res["rdid"] = $row2["rdid"]; 
		$res["sender_name"] = $row2["sender_name"]; 
		$res["distance"] = $row2["distance"]; 
		$res["cost"] = $row2["cost"]; 
		$res["origin_address"] = $row2["origin_address"]; 
		$res["destination_address"] = $row2["destination_address"]; 
		$res["item"] = $row2["item"]; 
		$res["recepient_name"] = $row2["recepient_name"]; 
		$res["package_name"] = $row2["package_name"]; 
		$res["location_lat"] = $row2["location_lat"]; 
		$res["location_long"] = $row2["location_long"]; 
		$res["note"] = $row2["note"]; 
		echo json_encode($res);	
	// }else{
	// 	$row2 = mysqli_fetch_assoc($query2);
	// 	echo json_encode($row2);	
	// }
}
?>