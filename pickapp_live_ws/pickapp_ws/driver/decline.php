<?php
include '../includes/dbconfig2.php';

$headerid = $_REQUEST['headerid'];
$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));

$query = "UPDATE request_header set assigned_driver = 0 where id = $headerid";
$query = $conn2->query($query);

$update = "UPDATE request_ledger set isDeclined = 1, dateTime_updated = '$new_time' where request_header_id = $headerid";
$conn2->query($update);

if($query){
	echo "OK";
}

?>