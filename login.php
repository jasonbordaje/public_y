<?php
session_start();

include('includes/dbconfig.php');
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$encpass = md5($password);
//mysqli_set_charset( $conn, 'utf8');
$sql = "SELECT * FROM mst_admin_user WHERE username = '$username' AND password = '$encpass' AND user_type = 1";
$sql = $conn->query($sql);

if($sql->num_rows>0){
	$row = mysqli_fetch_assoc($sql);
	$_SESSION['id'] = $row['id'];
	echo 1;
}
else{
	echo $username."<br".$password;
}

?>