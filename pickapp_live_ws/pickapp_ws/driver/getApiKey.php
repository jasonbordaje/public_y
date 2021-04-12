<?php
include '../includes/dbconfig2.php';

$username = $_REQUEST['usern'];

$query = "SELECT google_api_key from mst_admin_user where username = '$username'";
$query = $conn2->query($query);
$row = mysqli_fetch_assoc($query);

echo $row['google_api_key'];
?>