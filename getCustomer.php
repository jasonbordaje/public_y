<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;

$sql = "SELECT * FROM mst_user WHERE status = 1 ORDER BY firstname ASC";
$sql=  $conn->query($sql);

while($row = mysqli_fetch_assoc($sql)){
$result[$count]['id'] = $row['id'];
$result[$count]['fname'] = $row['firstname'];
$result[$count]['lname'] = $row['lastname'];
$result[$count]['balance'] = $row['balance'];

$count++;

}

echo json_encode($result);
?>