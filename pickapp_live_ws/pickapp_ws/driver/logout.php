<?php
include '../includes/driver/function.php';
session_start();
$loginid = $_SESSION['loginid'];
$hid = $_SESSION['headerid'];
putOffline($loginid);
putunAvailable($loginid);

session_unset($loginid);
session_unset($hid);
session_destroy();
?>