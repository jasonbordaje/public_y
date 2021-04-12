<?php
include("includes/dbconfig.php");
$result = [];
$count = 0;
$getItems = "SELECT * FROM package_type";
$getItems = $conn->query($getItems);

while($row = mysqli_fetch_assoc($getItems)){
$result[$count]['id'] = $row['id'];
$result[$count]['package_name'] = $row['package_name'];
$count++;
}

echo json_encode($result);
?>