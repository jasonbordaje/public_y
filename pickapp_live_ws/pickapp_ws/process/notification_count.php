<?php
include '../includes/dbconfig2.php';

session_start();
$loginid = $_SESSION['loginid'];

$query = "SELECT * from notifications where user_id = $loginid and status = 1";
$query = $conn2->query($query);
$numrows = mysqli_num_rows($query);

if($numrows > 0){
	echo $numrows;
}else{
	echo "0";
}

?>