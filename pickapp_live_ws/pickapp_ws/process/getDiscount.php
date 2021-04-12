<?php
include '../includes/dbconfig2.php';

$query = "SELECT * from user_discount";
$query = $conn2->query($query);
$row = mysqli_fetch_assoc($query);

echo json_encode($row);
?>