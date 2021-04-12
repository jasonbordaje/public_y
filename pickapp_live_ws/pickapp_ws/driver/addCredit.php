<?php
session_start();

$loginid = $_SESSION['id'];
$driverid = $_POST['driver'];
$amount = $_POST['amount'];
$newTime = date("Y-m-d H:i:s", strtotime('+8 hours'));


$query = "SELECT * from mst_admin_user where id = $driverid";
$query = $conn2->query($query);
$row = mysqli_fetch_assoc($query);

$oldBalance = $row['balance'];
$newBalance = $oldBalance + $amount;

$insert = "INSERT into balance_log (driverid, total_balance, added_amount, dateTime_added, added_by, method) values ($driverid, $newBalance, $amount, '$newTime',$loginid, 'RELOAD')";
$insert = $conn2->query($insert);

$update = "UPDATE mst_admin_user set balance = $newBalance where id = $driverid";
$conn2->query($update);

?>