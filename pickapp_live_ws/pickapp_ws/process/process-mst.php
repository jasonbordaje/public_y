<?php
include '../includes/dbconfig2.php';
include '../includes/function.php';

$action = $_REQUEST['action'];	
	
switch($action){

	case 'login':
	
	$username = trim($_POST['UserName']);
	$code = getCode($username);
	$password = md5($_POST['Password']);
	
		if (checkUsername($username) == 1) {
			
			if(checkStatus($username) == 1){

				if (checkPassword($username) == $password) {
				
					session_start();
					$_SESSION['loginid'] = getID($username);
					echo "success";	
				
				} else {
					echo "pi";
				}
			}else {
				echo $code;
			}
			
		} else {
			echo "nod";
		}
	
	exit();
	break;
	
	case 'userprofile':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	
	$fname = userInfo($loginid,"firstname");
	$mi = userInfo($loginid,"mi");
	$lname = userInfo($loginid,"lastname");

	$avatar = userInfo($loginid,"avatar");
	$date =  date("D F d, Y");
	//$avatar = "http://192.168.254.104/pickapp_ws/$avatar";
	
	echo '<div class="row">
			<div class="clearfix" style="padding-bottom: 15px; margin: 0 15px;">
			<div class="col-xs-3">
			<div style="width:60px; height:60px; border:0px solid #000; border-radius: 55px; background:url(images/momon.png); overflow:hidden;">	<img src="http://ods.gothong.com/pickapp_live_ws/pickapp_ws/'.$avatar.'" width="60" height="60"></div>
			<div style="font-size: 11px; margin-top: 5px; margin-left: -7px; margin-right: -10px"><a href="edit.html"><u style="color: #999;"> Edit Profile <span class="glyphicon glyphicon-pencil"></span></u></a></div>
			</div>
			<div class="col-xs-9">
			<p style="font-size: 20px!important; color: #333333; text-align: left; margin-bottom: 0">Welcome <strong>'.$fname.'</strong>!<input type="hidden" name="userid" id="userid" value="'.$loginid.'">
			<p style="font-size: 14px!important; color: #999; text-align: left; margin-bottom: 0">'.$date.'</p>
			<p id="location" style="font-size: 14px!important; color: #333333; text-align: left; margin-bottom: 0"><span class="glyphicon glyphicon-map-marker" style="color: #FF7B00"></span> Identifying Location...</p>
			</div></div></div>';
		
	exit();
	break;

}

?> 