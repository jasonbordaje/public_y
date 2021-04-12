<?php
include("includes/dbconfig.php");
$mobileno = [];
$val = $_REQUEST["val"];
$getNum = "SELECT * FROM request_details WHERE recepient_name = '$val' ";
$getNum = $conn->query($getNum);
$row = mysqli_fetch_assoc($getNum);
$mobileno["mobileno"] = $row["recepient_number"];
echo json_encode($mobileno);
?>