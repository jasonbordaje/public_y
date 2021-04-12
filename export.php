<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$_POST['filename'].'.csv"');

include('includes/dbconfig.php');
$filename = $_POST['filename'];
$startDate  = $_POST['startDate1'];
$endDate = $_POST['endDate1'];
$drr = $_POST['drr'];
$driverVal = $_POST['driverVal1'];
$count = 1;
$output = '';
$status = '';
$additionalcommand = '';
$condition = '';

if(isset($_POST["btn-download"])){
    $user_CSV[0] = array('No.', 'Status', 'Driver Assigned', 'Requested By', 'Item Requested', 'Origin Address', 'Destination Address', 'Distance', 'Cost', 'Date Requested', 'Date Delivered', 'Hours / Minutes Completed');
// 	echo 
	if($drr == 1){
		$status = "request_header.status='COMPLETED'";
	}else if($drr == 2){
		$status = "request_header.status='CANCELLED'";
	}else if($drr == 3){
		$status = "request_header.status='ACCEPTED'";
	}else{
		$status = "request_header.status<>''";
	}

	if($startDate != "" && $endDate != "" && $driverVal == 0){
		$additionalcommand = "dateTime_requested BETWEEN '$startDate' AND '$endDate' AND";
	}else if($startDate != "" && $endDate != "" && $driverVal != 0){
		$additionalcommand = "dateTime_requested BETWEEN '$startDate' AND '$endDate' AND mst_admin_user.id = $driverVal AND";
	}else if($startDate == "" && $endDate == "" && $driverVal != 0){
		$additionalcommand = "mst_admin_user.id = $driverVal AND";
	}

	if($drr != '' || $driverVal != ''){
		$condition = "WHERE";
	}

	$sql  = "SELECT request_header.status, request_header.dateTime_requested, request_header.dateTime_delivered,request_header.requested_by, mst_user.firstname, mst_user.lastname, package_type.package_name, request_details.origin_address, request_details.destination_address, request_details.distance, request_details.cost, mst_admin_user.fname, mst_admin_user.lname FROM request_header INNER JOIN request_details ON request_header.id = request_details.request_header_id INNER JOIN mst_user ON request_header.requested_by = mst_user.id INNER JOIN package_type ON request_details.package_type = package_type.id INNER JOIN mst_admin_user ON request_header.assigned_driver = mst_admin_user.id ".$condition." ".$additionalcommand." ".$status." ORDER BY request_header.dateTime_requested DESC";
	$sql = $conn->query($sql);

    $array_count = 1;
	while($row = mysqli_fetch_assoc($sql)){	
		$requestDate = $row['dateTime_requested'];
		$requestDelivered = $row['dateTime_delivered'];

		$hourdiff = round((strtotime($requestDelivered) - strtotime($requestDate))/3600, 1);
		$hourdiff1 = $hourdiff."Hours / Minutes";
        
        $user_CSV[$array_count] = array($array_count, $row["status"], $row["fname"].' '.$row["lname"], $row["firstname"].' '.$row["lastname"], $row["package_name"], $row["origin_address"], $row["destination_address"], $row["distance"], $row["cost"], $row["dateTime_requested"], $row["dateTime_delivered"], $hourdiff1);
        $array_count++;
	}

    $fp = fopen('php://output', 'wb');
    foreach ($user_CSV as $line) {
        fputcsv($fp, $line, ',');
    }
    fclose($fp);
}
?>