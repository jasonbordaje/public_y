<?php
session_start();

include('includes/dbconfig.php');
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$encpass = md5($password);
//mysqli_set_charset( $conn, 'utf8');
$sql = "SELECT mau.id, locations.location_lat FROM mst_admin_user as mau LEFT JOIN locations ON mau.location_id = locations.id  WHERE mau.username = '$username' AND mau.password = '$encpass' AND mau.user_type = 1";
$sql = $conn->query($sql);

if($sql->num_rows>0){
	
	$row = mysqli_fetch_assoc($sql);
	$_SESSION['id'] = $row['id'];
	$_SESSION['location_index'] = $row['location_lat'];
	echo 1;
}
else{
	echo $username."<br".$password;
}

?>