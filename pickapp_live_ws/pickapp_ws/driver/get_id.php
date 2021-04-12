<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';

$username = $_REQUEST['username'];

$id = getID($username);
session_start();
$_SESSION['loginid'] = $id;
putOnline($id);
putAvailable($id);
echo $id;
?>