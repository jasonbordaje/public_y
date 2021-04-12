<?php
include("includes/dbconfig.php");
$id = $_REQUEST['dynamicID'];
$sql = "SELECT mobileno FROM mst_user WHERE id = $id";
$sql = $conn->query($sql);
$row = mysqli_fetch_assoc($sql);

echo json_encode($row);