<?php
include '../includes/dbconfig2.php';

$headerid = $_REQUEST['headerid'];
$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));
$day = date("D", strtotime('+8 hours'));

//check if date_scheduled is null or not
$sql = "SELECT * FROM request_header WHERE id = $headerid";
$sql = $conn2->query($sql);
$sqlrow = mysqli_fetch_assoc($sql);

if($sqlrow["dateTime_scheduled"] == NULL){
	$status = "CONFIRMED";
}else{
	$status = "SCHEDULED";
}

$query = "UPDATE request_header set status = '$status', dateTime_updated = '$new_time' where id = $headerid";
$conn2->query($query);

$query1 = "UPDATE request_details set details_status = 'CONFIRMED' where request_header_id = $headerid";
$conn2->query($query1);

if ($day == "Sat") {
	$karon = date('Ymdhis', strtotime('+8 hours'));
			$arr_post_body = array(
				"message_type" => "SEND",
				"mobile_number" => "639356067990",
				"shortcode" => "29290277721",
				"message_id" => "ADMINPICKAPPALERT".$karon,
				"message" => urlencode("From PickApp: Hi Admin, pls assign the new confirmed request."),
				"client_id" => "d52b15dcc5779c1	97bd80bc9891b5d829844753a5f80ba4cb0e8d75270b54f8b",
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
}

?>