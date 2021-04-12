<?php
include('includes/dbconfig.php');
$id = $_REQUEST['id'];

$sql = "SELECT * FROM mst_admin_user WHERE id = $id";
$sql = $conn->query($sql);
$row = mysqli_fetch_assoc($sql);
$balance = $row['balance'];

echo $balance;
?>