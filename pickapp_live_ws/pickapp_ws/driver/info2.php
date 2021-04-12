<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';

session_start();

$loginid = $_SESSION['loginid'];
$fname = userInfo($loginid,"fname");
$lname = userInfo($loginid,"lname");
$avatar = userInfo($loginid, "avatar");
$balance = userInfo($loginid, "balance");
$today = date("l, d F o");

	echo "
		<div class='clearfix' style='padding: 8px 8px; height: 100%; border:0px solid #000; width:100%; margin-top: 20px'>
			<div class='col-xs-12' style='height: 100%; color: white; font-size: 30px; text-align: center; overflow: hidden; color: #333'>".$fname." ".$lname."</div>
			<div class='col-xs-12' id='driverlocation' style='height: 100%; color: white; font-size: 15px; text-align: center; overflow: hidden; color: #333'><span style='font-size: 15px; color: orange' class='glyphicon glyphicon-map-marker'></span> Identifying location...</div>
		</div>		
		<div class='clearfix' style='padding: 8px 8px; height: 100%; border:0px solid #000; width:100%;'>
			<div class='col-xs-12' style='height: 100%;'><center><img align='middle' class='img-circle' src='http://ws.yellox.ph/pickapp_ws/".$avatar."' alt=' ' style='border: solid 1px white; height: 80px; width: 80px; margin-bottom: 20px;'></center></div>
		</div>
		<div class='clearfix' style='margin-bottom: 20px'>
			<div class='col-xs-10' style='color: #333; font-size: 15px'>Yello-X Balance: <strong><div style='font-size: 20px'> &#8369 ".number_format($balance,2 ,'.', ',')."</div></strong></div>
		</div>
		";
	?>