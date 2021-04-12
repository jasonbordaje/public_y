<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';

session_start();

$loginid = $_SESSION['loginid'];
$fname = userInfo($loginid,"fname");
$avatar = userInfo($loginid, "avatar");
$today = date("l, d F o");

	echo "<div class='row' style='padding: 8px 8px; background-color: #cccccc; height: 100%; border:0px solid #000; width:100%;'>
			<div class='container' style='background-color: #cccccc; height: 10%'></div>
			<div class='container' style='background-color: #cccccc; height: 80%'>
				<div class='col-xs-3' style='height: 100%'><img class='img-circle' src='http://pickapp.cssolutions.ph/pickapp_ws/".$avatar."' style='height: 60px; width: 60px; background:url(images/default.jpg);'></div>
				<div class='col-xs-9' style='height: 100%'>
					<div style='height: 33%; color: #333
					'>
						Welcome <strong style='color: #333'>".$fname."!</strong>
					</div>
					<div style='height: 33%'>
						today is ".$today."
					</div>
					<div id='location' style='height: 33%' class='glyphicon glyphicon-map-marker'> Identifying location...</div>
				</div>
			</div>
			<div class='container' style='background-color: #cccccc; height: 10%'></div>
		</div>";
	?>
	