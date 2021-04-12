<?php
include('includes/dbconfig.php');

$sql = "SELECT * FROM mst_user WHERE id = 1 ";
$sql = $conn->query($sql);

while($row4 = mysqli_fetch_assoc($sql)){
    $mobile_number = $row4['mobileno'];
    $receiverName = $row4['firstname'];
    $date1 = date("Ymds");

    $arr_post_body = array(
        "message_type" => "SEND",   
        "mobile_number" => "63".$mobile_number,
        "shortcode" => "29290277721",
        "message_id" => "CSSOLUTIONSPICKAPP".$date1,
        "message" => urlencode("Hi ".$receiverName.", please be informed that a new version of PickApp v1.0.6 is now available on Google Play Store. https://play.google.com/store/apps/details?id=com.phonegap.pickapp This update solves bugs and other issues on the current version. We are continously working to make PickApp better and we would like to hear from you. For your suggestion and comments please send us an email at info@cssolutions.ph. We look forward to hearing from you, thank you and good day!"),
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
}
?>