<?php
include("includes/dbconfig.php");
$requestId = $_REQUEST["idCompleted"];
$driverId = $_REQUEST["selectDriverid"];
$receivedBy = $_REQUEST["receivedby"];
$dateTime_delivered = date('Y-m-d H:i:s', strtotime('+8 hours'));

$getuser = "SELECT requested_by FROM request_header WHERE id = $requestId";
$getuser = $conn->query($getuser);
$getuser = mysqli_fetch_assoc($getuser);
$userid = $getuser["requested_by"];

$update = "UPDATE request_header SET status = 'COMPLETED' , at_pickup = 1, at_dropoff = 1, assigned_driver = $driverId, receivedby = '$receivedBy', dateTime_delivered = '$dateTime_delivered' WHERE id = $requestId";
$update = $conn->query($update);

if($update){
	echo "success";

	$availableDriver = "UPDATE driver_availability SET is_available = 1, is_online = 1 WHERE driver_id = $driverId";
	$availableDriver = $conn->query($availableDriver);
	//send message
	$sql = "SELECT firstname, mobileno FROM mst_user WHERE id= $userid";
	$sql = $conn->query($sql);
	$row = mysqli_fetch_assoc($sql);

	$name = $row['firstname'];
	$mobnum = $row['mobileno'];
	
	$date1 = date("Ymds");
	    $arr_post_body = array(
	        "message_type" => "SEND",
	        "mobile_number" => "63".$mobnum,
	        "shortcode" => "29290277721",
	        "message_id" => "CSSOLUTIONSRED".$date1,
	        "message" => urlencode("From PickApp: Hi ".$name.", your item has been delivered and received by: ".$receivedBy." on ".$dateTime_delivered.". Please check your email to view Delivery Report."),
	        "client_id" => "d52b15dcc5779c197bd80bc9891b5d829844753a5f80ba4cb0e8d75270b54f8b",
	        "secret_key" => "857525ac40f87c114d25788b3f890a90cd1c869522c4c14311faa2426a983d3f"
	    );

	    $query_string = "";
	    foreach($arr_post_body as $key => $frow)
	    {
	        $query_string .= '&'.$key.'='.$frow;
	    }

	    $URL = "https://post.chikka.com/smsapi/request";

	    $curl_handler = curl_init();
	    curl_setopt($curl_handler, CURLOPT_URL, $URL);
	    curl_setopt($curl_handler, CURLOPT_POST, count($arr_post_body));
	    curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
	    curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($curl_handler, CURLOPT_SSL_VERIFYPEER, false);
	    $response = curl_exec($curl_handler);

	    curl_close($curl_handler);
}else{
	echo mysqli_error($conn);
}
?>