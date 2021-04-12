<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;

$sql = "SELECT * FROM mst_admin_user WHERE user_type = 2";
$sql=  $conn->query($sql);

while($row = mysqli_fetch_assoc($sql)){
$result[$count]['id'] = $row['id'];
$result[$count]['fname'] = $row['fname'];
$result[$count]['lname'] = $row['lname'];
$result[$count]['balance'] = $row['balance'];

$count++;

}

echo json_encode($result);
?>