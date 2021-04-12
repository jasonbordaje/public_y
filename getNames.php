<?php
include("includes/dbconfig.php");
$queryName = $_REQUEST['typeName'];
$result = [];
$count = 0;
$getRegularAcct = "SELECT * FROM mst_user WHERE firstname LIKE '%{$queryName}%' ";
$getRegularAcct = $conn->query($getRegularAcct);

while($row = mysqli_fetch_assoc($getRegularAcct)){
$result[$count]['id'] = $row['id'];
$result[$count]['firstname'] = $row['firstname'];
$result[$count]['mi'] = $row['mi'];
$result[$count]['lastname'] = $row['lastname'];
$result[$count]['mobileno'] = $row['mobileno'];
$count++;
}
echo json_encode($result);
?>