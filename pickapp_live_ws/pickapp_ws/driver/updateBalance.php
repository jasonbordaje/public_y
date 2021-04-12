<?php
include '../includes/dbconfig2.php';

session_start();

$loginid = $_SESSION['loginid'];
$newBalance = $_REQUEST['newBalance'];
$newTime = date("Y-m-d H:i:s", strtotime('+8 hours'));

$query = "SELECT balance FROM mst_admin_user where id = $loginid";
$query = $conn2->query($query);
$row = mysqli_fetch_assoc($query);

$oldBalance = $row['balance'];
$deductedAmount = $oldBalance - $newBalance;

$update = "UPDATE mst_admin_user set balance = $newBalance where id = $loginid";
$conn2->query($update);

$insert = "INSERT into balance_log (driver_id, total_balance, deducted_amount, dateTime_deducted, action_by, method) values ($loginid, $newBalance, $deductedAmount, '$newTime', 0, 'COMMISSION')";
$insert = $conn2->query($insert);

if(!$insert){
    echo mysqli_error($conn2);
}

?>