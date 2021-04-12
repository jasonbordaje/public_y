<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';

$headerid = $_REQUEST['headerid'];

if (empty($headerid)) {
	session_start();
	$headerid = $_SESSION['headerid'];
}

$query2 = "SELECT * from request_details where request_header_id = $headerid AND (details_status = 'ACCEPTED' OR details_status = 'CONFIRMED')";
$query2 = $conn2->query($query2);
$numrows = mysqli_num_rows($query2);

if($numrows > 0){
	// if($numrows > 1){
	// 	$count = 0; $res = [];
	// 	while($row2 = mysqli_fetch_assoc($query2)){
	// 		$res[$count]["sender_name"] = $row2["sender_name"]; 
	// 		$res[$count]["distance"] = $row2["distance"]; 
	// 		$res[$count]["cost"] = $row2["cost"]; 
	// 		$res[$count]["origin_address"] = $row2["origin_address"]; 
	// 		$res[$count]["destination_address"] = $row2["destination_address"]; 
	// 		$res[$count]["item"] = $row2["item"]; 
	// 		$res[$count]["recepient_name"] = $row2["recepient_name"]; 
	// 		$res[$count]["origin_lat"] = $row2["origin_lat"]; 
	// 		$res[$count]["origin_lng"] = $row2["origin_lng"]; 
	// 		$res[$count]["destination_lat"] = $row2["destination_lat"]; 
	// 		$res[$count]["destination_lng"] = $row2["destination_lng"]; 
	// 		$count++;
	// 	}
	// 	echo json_encode($res);	
	// }else{
		$row2 = mysqli_fetch_assoc($query2);
		echo json_encode($row2);	
	// }

}
?>