<?php
include("includes/dbconfig.php");
$headerID = mysqli_real_escape_string($conn, $_REQUEST['idd']);
$accountID = mysqli_real_escape_string($conn, $_REQUEST['accountID']);
$itemType = mysqli_real_escape_string($conn, $_REQUEST['itemType']);
$sendersName = mysqli_real_escape_string($conn, $_REQUEST['sendersName']);
$senderContact = mysqli_real_escape_string($conn, $_REQUEST['senderContact']);
$receiversName = mysqli_real_escape_string($conn, $_REQUEST['receiversName']);
$receiverContact = mysqli_real_escape_string($conn, $_REQUEST['receiverContact']);
$pickUpLat = mysqli_real_escape_string($conn, $_REQUEST['pickUpLat']);
$pickUpLng = mysqli_real_escape_string($conn, $_REQUEST['pickUpLng']);
$dropOffLat = mysqli_real_escape_string($conn, $_REQUEST['dropOffLat']);
$dropOffLng = mysqli_real_escape_string($conn, $_REQUEST['dropOffLng']);
$pickUpArea = mysqli_real_escape_string($conn, $_REQUEST['pickUpArea']);
$dropOffArea = mysqli_real_escape_string($conn, $_REQUEST['dropOffArea']);
$note = mysqli_real_escape_string($conn, $_REQUEST['note']);
$distance = mysqli_real_escape_string($conn, $_REQUEST['distance']);
$cost = mysqli_real_escape_string($conn, floatval($_REQUEST['cost']));
$deliveryTime = mysqli_real_escape_string($conn, $_REQUEST['deliveryTime']);
$rbal = mysqli_real_escape_string($conn, $_REQUEST['rbal']);

$getPackID = "SELECT id FROM package_type WHERE package_name = '$itemType' ";
$getPackID = $conn->query($getPackID);
$row = mysqli_fetch_assoc($getPackID);
$packid = $row["id"];

$insertDetails = "INSERT INTO request_details (request_header_id, item, sender_name, sender_contact, recepient_name, recepient_number, package_type, origin_lat, origin_lng, destination_lat, destination_lng, origin_address, destination_address, distance, cost, note, tod) VALUES ($headerID, '$itemType', '$sendersName', '$senderContact', '$receiversName', '$receiverContact', $packid ,'$pickUpLat', '$pickUpLng',  '$dropOffLat' ,  '$dropOffLng ',  '$pickUpArea',' $dropOffArea',  '$distance', $cost, '$note', '$deliveryTime')";
$insertDetails = $conn->query($insertDetails);

$confirmReq = "UPDATE request_header SET status = 'CONFIRMED' WHERE id = $headerID";
$confirmReq = $conn->query($confirmReq);

$updateMst = "UPDATE mst_user SET balance = $rbal WHERE id = $accountID";
$updateMst = $conn->query($updateMst);

if($insertDetails){
	echo "success";
}else{
	echo mysqli_error($conn);
}
?>