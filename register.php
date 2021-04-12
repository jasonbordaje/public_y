<?php
include('includes/dbconfig.php');
error_reporting(0);
$userType = $_POST['usertype'];
$userName = $_POST['username'];
$password = $_POST['password'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$mname = $_POST['mname'];
$contactno = $_POST['contactnumber'];
$emailadd = $_POST['emailadd'];
$licenseno = $_POST['licenseno'];
$api_key = $_POST['apikey'];
$encpass = md5($password);
$createdate= date('Y-m-d H:i:s', strtotime('+8 hours'));
$imgVal = $_FILES['uploadP']['name'];
$imgVal1 = "user_avatar/1/".$imgVal;

$sql = "INSERT INTO mst_admin_user (username, password, fname, lname, mname, avatar, contact_no, email_add, licenseno, user_type, created_by, dateTime_created, google_api_key) VALUES('$userName', '$encpass', '$fname', '$lname', '$mname', '$imgVal1', '$contactno', '$emailadd', '$licenseno', '$userType', 1, '$createdate', '$api_key')";
$sql = $conn->query($sql);

$driverID = $conn->insert_id;

$sql2 = "INSERT INTO driver_availability (driver_id, is_online, is_available) VALUES($driverID, 0, 0)";
$sql2 = $conn->query($sql2);


$uploaddir = '../ws.yellox.ph/pickapp_ws/user_avatar/1/';
$uploadfile = $uploaddir . basename($_FILES['uploadP']['name']);

$uploaddirapp = '../app.yellox.ph/browser_ws/user_avatar/1/';
$uploadfileapp = $uploaddirapp . basename($_FILES['uploadP']['name']);

if (move_uploaded_file($_FILES['uploadP']['tmp_name'], $uploadfile)) {
	if (copy($uploadfile, $uploadfileapp)) {
		if($sql){	
			echo "<script>alert('Success, User inserted Successfully!');
			window.location.replace('dashboard.php')</script>";
		}
		else{
			echo "<script>alert('Error inserting user!');
			window.location.replace('dashboard.php')</script>";
		}
	} else {
	   echo "<script>alert('Upload Failed!');</script>";
	}
} else {
   echo "<script>alert('Upload Failed!');</script>";
}

?>