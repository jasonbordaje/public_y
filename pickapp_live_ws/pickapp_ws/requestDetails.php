<?php
include 'includes/dbconfig2.php';
include 'includes/function.php';

session_start();
$now = date('Y-m-d H:i:s', strtotime('+8 hours'));
//$loginid = $_SESSION['loginid'];
$loginid = $_REQUEST['userid'];
$item = $_REQUEST['item'];
$name = addslashes($_REQUEST['name']);
$number = $_REQUEST['number'];
$packtype = $_REQUEST['pack'];
$originlat = $_REQUEST['originlat'];
$originlng = $_REQUEST['originlng'];
$destinationlat = $_REQUEST['destinationlat'];
$destinationlng = $_REQUEST['destinationlng'];
$note = addslashes($_REQUEST['note']);
$oaddress = addslashes($_REQUEST['oaddress']);
$daddress = addslashes($_REQUEST['daddress']);
$distance = $_REQUEST['distance'];
$cost = $_REQUEST['cost'];
$transtype = intval($_REQUEST['transtype']);

$fname = userInfo($loginid,"firstname");
$mname = userInfo($loginid,"mi");
$lname = userInfo($loginid,"lastname");
$compname = $fname.' '.$mname.' '.$lname;
$compnum = userInfo($loginid,"mobileno");
if($transtype == 1){
	$sendername = $compname;
	$sendercontact = $compnum;
	$receivername = $name;
	$receivercontact = $number;
}else{
	$sendername = $name;
	$sendercontact = $number;
	$receivername = $compname;
	$receivercontact = $compnum;
}

$query = "INSERT into request_header (requested_by, status, transtype,dateTime_requested) values ($loginid, 'PENDING', $transtype,'$now')";
$query = $conn2->query($query);

$queryid = "SELECT * from request_header where requested_by = $loginid ORDER by id DESC LIMIT 1";
$queryid = $conn2->query($queryid);
$row = mysqli_fetch_assoc($queryid);
$result = $row['id'];
$invoice = str_pad( $result, 4, "0", STR_PAD_LEFT );
$update = "UPDATE request_header set invoice_no = '$invoice' where id = $result";
$conn2->query($update);

$insert = "INSERT into request_details (request_header_id, item, sender_name, sender_contact, recepient_name, recepient_number, package_type, origin_lat, origin_lng, destination_lat, destination_lng, note, origin_address, destination_address, distance, cost) values ($result, '$item', '$sendername', '$sendercontact', '$receivername', '$receivercontact', '$packtype', '$originlat', '$originlng', '$destinationlat', '$destinationlng', '$note', '$oaddress', '$daddress', '$distance', '$cost')";
$conn2->query($insert);

if($insert){
	echo "GOOD";
}

?>