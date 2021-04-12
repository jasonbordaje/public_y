<?php
include '../includes/dbconfig2.php';
include '../includes/function.php';

session_start();

$loginid = $_SESSION['loginid'];
$fname = userInfo($loginid,"firstname");
$avatar = userInfo($loginid, "avatar");
if($avatar == null || $avatar == ""){
	$avatar = 'user_avatar/1/default-pic.jpg';
}
$today = date("l, d F o");

	echo "<div class='row' style='padding: 10px 10px; background-color: #cccccc; height: 100%'>
			<div class='container' style='background-color: #cccccc; height: 10%'></div>
			<div class='container' style='background-color: #cccccc; height: 80%'>
				<div class='col-xs-3' style='height: 100%'><img class='img-circle' src='http://ws.yellox.ph/pickapp_ws/".$avatar."' style='height: 100%; width: auto;'></div>
				<div class='col-xs-9' style='height: 100%'>
					<div style='height: 33%; color: #333'>
						Welcome <strong>".$fname."!</strong>
					</div>
					<div style='height: 33%'>
						".$today."
					</div>
					<div id='location' style='height: 33%'><span class='glyphicon glyphicon-map-marker' style='color: #FF7B00;'></span> Identifying location...</div>
				</div>
			</div>
			<div class='container' style='background-color: #cccccc; height: 10%'></div>
		</div>";
	?>