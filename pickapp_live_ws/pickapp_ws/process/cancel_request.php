<?php
include '../includes/dbconfig2.php';

$headerid = $_REQUEST['headerid'];
$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));


$query = "UPDATE request_header set status = 'CANCELLED', dateTime_updated = '$new_time' where id = $headerid";
$conn2->query($query);

?>