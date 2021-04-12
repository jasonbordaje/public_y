<?php
include("includes/dbconfig.php");

$result = [];
$count = 0;
$getRegularAcct = "SELECT * FROM mst_user WHERE corporate = 0";
$getRegularAcct = $conn->query($getRegularAcct);

while($row = mysqli_fetch_assoc($getRegularAcct)){
$result[$count]['id'] = $row['id'];
$result[$count]['firstname'] = $row['firstname'];
$result[$count]['mi'] = $row['mi'];
$result[$count]['lastname'] = $row['lastname'];
$result[$count]['mobileno'] = $row['mobileno'];
$result[$count]['balance'] = $row['balance'];
$count++;
}
echo json_encode($result);
?>