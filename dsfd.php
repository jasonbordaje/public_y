<?php
include('includes/dbconfig.php');
$count = 0;
 $sql = "SELECT * FROM mst_user WHERE status = 1";
 $sql = $conn->query($sql);

while ($row = mysqli_fetch_assoc($sql)) {

	//$name = "Ramon Angeles";
	$mobile = $row['mobileno'];
	$message = "Sales Monitoring System as low as 20k, with basic inventory management and full POS function, perfect for small business. Pls reply to this number if interested!";
	$arr_post_body = array(
					"message_type" => "SEND",
			        "mobile_number" => "63".$mobile,
			        "message" => urlencode($message),
			        "client_id" => "1",
			        "secret_key" => "857525ac40f87c114d25788b3f890a90cd1c869522c4c14311faa2426a983d3f"
				);
				
		$query_string = "";
				foreach($arr_post_body as $key => $frow)
				{
					$query_string .= '&'.$key.'='.$frow;
				}
			
				$URL = "http://textmate.cssolutions.ph/post/";
			
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