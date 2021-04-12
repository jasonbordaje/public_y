<?php
include '../includes/dbconfig2.php';

session_start();
$id = $_SESSION['loginid'];

$fname = $_REQUEST['fname'];
$mname = $_REQUEST['mname'];
$lname = $_REQUEST['lname'];
$mobileno = $_REQUEST['contact'];
$email = $_REQUEST['email'];
$password = md5($_REQUEST['password']);


$query = "UPDATE mst_user set firstname = '$fname', mi = '$mname', lastname = '$lname', mobileno = '$mobileno', emailadd = '$email', password = '$password' where id = $id";
$conn2->query($query);

echo "GOOD";
?>