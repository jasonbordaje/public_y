<?php
header('Access-Control-Allow-Origin: *');
session_start();
if(isset($_SESSION['loginid'])) {
    $result =  ['bdashboard'];
}else{
	$result =  ['login'];
}
echo json_encode($result);
?>