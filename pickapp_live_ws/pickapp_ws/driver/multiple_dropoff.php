<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';


$headerid = $_REQUEST['headerid'];

if (empty($headerid)) {
	session_start();
	$headerid = $_SESSION['headerid'];
}

$query2 = "SELECT * from request_details where request_header_id = $headerid";
$query2 = $conn2->query($query2);
$numrows = mysqli_num_rows($query2);

if($numrows > 0){
	// if($numrows > 1){
		$count = 0; $res = [];
		while($row2 = mysqli_fetch_assoc($query2)){
			$res[$count]["destination_address"] = $row2["destination_address"]; 
			$res[$count]["destination_lat"] = $row2["destination_lat"]; 
			$res[$count]["destination_lng"] = $row2["destination_lng"]; 
			$res[$count]["details_status"] = $row2["details_status"]; 
			$count++;
        }
        echo json_encode($res);	
    // }
		

}
?>