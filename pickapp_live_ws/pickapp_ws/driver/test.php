<?php
$arr_post_body = array(
				"message_type" => "SEND",
				"mobile_number" => "639228052163",
				"shortcode" => "29290277721",
				"message_id" => "CSSOLUTIONSPICKAPP",
				"message" => urlencode("Your item has been delivered and received by: ".$rname." on ".$now),
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
?>