<?php
session_start();

include('includes/dbconfig.php');
$loginid = $_SESSION['id'];
$customerid = $_POST['driver'];
$amount = $_POST['amount'];
$newTime = date("Y-m-d H:i:s", strtotime('+8 hours'));

$getAdminName = "SELECT * FROM mst_admin_user WHERE id = $loginid";
$getAdminName = $conn->query($getAdminName);
$row1 = mysqli_fetch_assoc($getAdminName);
$adminFname = $row1['fname'];
$adminLname = $row1['lname'];
$finalName = $adminFname." ".$adminLname;

$query = "SELECT * from mst_user where id = $customerid";
$query = $conn->query($query);
$row = mysqli_fetch_assoc($query);

$oldBalance = $row['balance'];
$newBalance = $oldBalance + $amount;

$insert = "INSERT into user_balance (userID, addedAmount ,balance, dateTime_updated, addedBy) values ($customerid, $amount ,$newBalance,'$newTime', '$finalName')";
$insert = $conn->query($insert);

$update = "UPDATE mst_user set balance = $newBalance where id = $customerid";
$conn->query($update);

echo "<script>window.location.replace('paCustomer.php')</script>";
?>