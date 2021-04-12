<?php
    $arr_post_body = array(
        "message_type" => "SEND",
        "mobile_number" => "639223852168",
        "shortcode" => "29290817081",
        "message_id" => "pickapp099241589324561234",
        "message" => urlencode("Pick App Test SMS!"),
        "client_id" => "631597443e702d8bf152ddcaaf69a34c93a900d399bd031e0b6080bf57f2509c",
        "secret_key" => "a1e1f94f564c82325468b558acfd5c07a60a13d3c897bc42c6160655094061e6"
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


