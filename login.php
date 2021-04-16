<?php
session_start();

include('includes/dbconfig.php');
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$encpass = md5($password);
//mysqli_set_charset( $conn, 'utf8');
$sql = "SELECT locations.location_long, mau.user_type, mau.id, locations.location_lat, locations.id as  location_id FROM mst_admin_user as mau LEFT JOIN locations ON mau.location_id = locations.id  WHERE mau.username = '$username' AND mau.password = '$encpass' AND mau.user_type IN (1,3)";
$sql = $conn->query($sql);

if($sql->num_rows>0){
	$row = mysqli_fetch_assoc($sql);
	$_SESSION['id'] = $row['id'];
	$_SESSION['location_index'] = $row['location_lat'];
	$_SESSION['location_id'] = $row['location_id'];
	$_SESSION['user'] = $row;
	echo 1;
}
else{
	echo $username."<br".$password;
}

?>