<?php
include 'includes/dbconfig2.php';

$loginid = $_REQUEST['userid'];

$query = "SELECT * from request_header where requested_by = $loginid ORDER by id DESC LIMIT 1";
$query = $conn2->query($query);
$row = mysqli_fetch_assoc($query);

$headerid = $row['id'];

$query2 = "SELECT * from request_details where request_header_id = $headerid";
$query2 = $conn2->query($query2);
$numrows = mysqli_num_rows($query2);

if($numrows > 0){
	$row2 = mysqli_fetch_assoc($query2);
	$packageid = $row2['package_type'];

	$package = "SELECT package_name from package_type where id = $packageid";
	$package = $conn2->query($package);
	$row3 = mysqli_fetch_assoc($package);

		$row2['package_type'] = $row3['package_name'];
		echo json_encode($row2);	
}
?>