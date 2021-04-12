<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;
$lineNo = 0;

$sql = "SELECT * FROM mst_admin_user WHERE user_type = 2";
$sql = $conn->query($sql);

while($row=mysqli_fetch_assoc($sql)){
$lineNo++;
$result[$count]['lineNo']  = $lineNo;
$result[$count]['id']  = $row['id'];
$result[$count]['fname']  = $row['fname'];
$result[$count]['lname']  = $row['lname'];
$result[$count]['contact_no']  = $row['contact_no'];
$result[$count]['email_add']  = $row['email_add'];
$result[$count]['licenseno']  = $row['licenseno'];
$result[$count]['dateTime_created']  = $row['dateTime_created'];
$result[$count]['google_api_key']  = $row['google_api_key'];

$count++;
}

echo json_encode(array('data' => $result));

?>