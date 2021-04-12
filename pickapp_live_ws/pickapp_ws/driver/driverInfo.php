<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';

session_start();

$loginid = $_SESSION['loginid'];

$query = "SELECT * FROM mst_admin_user WHERE id = $loginid";
$query = $conn2->query($query);

$result = mysqli_fetch_assoc($query);

echo json_encode($result);
?>
	