<?php
session_start();
include('includes/dbconfig.php');

$loginid = $_SESSION['id'];
$driverid = $_POST['driver'];
$amount = $_POST['amount'];
$newTime = date("Y-m-d H:i:s", strtotime('+8 hours'));


$query = "SELECT * from mst_admin_user where id = $driverid";
$query = $conn->query($query);
$row = mysqli_fetch_assoc($query);

$oldBalance = $row['balance'];
$newBalance = $oldBalance + $amount;

$insert = "INSERT into balance_log (driver_id, total_balance, added_amount, dateTime_added, action_by, method) values ($driverid, $newBalance, $amount, '$newTime',$loginid, 'RELOAD')";
$insert = $conn->query($insert);

$update = "UPDATE mst_admin_user set balance = $newBalance where id = $driverid";
$conn->query($update);

echo "<script>window.location.replace('paDrivers.php')</script>";
?>