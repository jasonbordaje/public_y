<?php
include '../includes/dbconfig2.php';

$query = "SELECT * FROM rate ORDER by dateTime_updated DESC LIMIT 1";
$query = $conn2->query($query);

$row = mysqli_fetch_assoc($query);

echo $row['rate'];

?>