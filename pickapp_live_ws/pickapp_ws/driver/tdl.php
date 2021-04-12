<?php
include '../includes/dbconfig2.php';

$query = "TRUNCATE TABLE `delivery_tracking`";
$query = $conn2->query($query);
?>