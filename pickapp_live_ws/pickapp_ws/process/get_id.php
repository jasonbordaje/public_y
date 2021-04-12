<?php
include '../includes/dbconfig2.php';
session_start();
$username = $_REQUEST['username'];

$query = "SELECT * from mst_user where username = '$username'";
$query = $conn2->query($query);

$row = mysqli_fetch_assoc($query);

$result = $row['id'];
$_SESSION['loginid'] = $result;

echo $result;
?>