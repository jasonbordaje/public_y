<?php
include '../includes/dbconfig2.php';

session_start();
$userid = $_SESSION['loginid'];
$headerid = $_REQUEST['headerid'];
$newBalance = $_REQUEST['newBalance'];
$discountedCost = $_REQUEST['discountedCost'];

$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));

$query = "UPDATE mst_user set balance = $newBalance where id = $userid";
$query = $conn2->query($query);

$query2 = "INSERT into user_balance_log (userID, request_header_id, requestCost, remainingBalance, dateTime_added) values ($userid, $headerid, $discountedCost, $newBalance, '$new_time')";
$query2 = $conn2->query($query2);

if($query && $query2){
	echo "GOOD";
}else{
	echo "BAD";
}


?>