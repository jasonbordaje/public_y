<?php
include('includes/dbconfig.php');

$driverID = $_REQUEST['driverID'];
$passIDRequest = $_REQUEST['passIDRequest'];

$result = [];

$sql = "SELECT * FROM request_ledger WHERE request_header_id = $passIDRequest AND driver_id = $driverID";
$sql = $conn->query($sql);
$row = mysqli_fetch_assoc($sql);

$sql1 = "SELECT * FROM mst_admin_user WHERE id= $driverID";
$sql1 = $conn->query($sql1);
$row1 = mysqli_fetch_assoc($sql1);

$fname = $row1['fname'];
$isDeclined = $row['isDeclined'];
$isConfirmed = $row['isConfirmed'];
$avatar = $row1['avatar'];
$declined_by = $row['declined_by'];

$result['declinedBy'] = $declined_by;
$result['fname'] = $fname;
$result['isDeclined'] = $isDeclined;
$result['isConfirmed'] = $isConfirmed;
$result['avatar'] = $avatar;

echo json_encode($result);
?>