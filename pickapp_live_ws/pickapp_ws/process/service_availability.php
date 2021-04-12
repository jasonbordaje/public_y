<?php
include '../includes/dbconfig2.php';

$transpoType = $_REQUEST['transpoType'];

$query = "SELECT * FROM service_availability WHERE serviceType = $transpoType";
$query = $conn2->query($query);
$result = mysqli_fetch_assoc($query);

echo json_encode($result);

?>