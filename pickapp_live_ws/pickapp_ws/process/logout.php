<?php
session_start();

$loginid = $_SESSION['loginid'];
$hid = $_SESSION['headerid'];

session_unset($loginid);
session_unset($hid);
session_destroy();
?>