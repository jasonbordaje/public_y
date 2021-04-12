<?php
include '../includes/dbconfig2.php';

$vtype = $_REQUEST['vtype'];

$query = "SELECT * FROM transportation_type where id = $vtype";
$query = $conn2->query($query);

$row = mysqli_fetch_assoc($query);

echo json_encode($row);

?>