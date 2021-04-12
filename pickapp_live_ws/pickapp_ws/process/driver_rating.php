<?php
include '../includes/dbconfig2.php';
header('Access-Control-Allow-Origin: *');

session_start();
$hid = $_REQUEST['headerid'];
$rating = $_REQUEST['rating'];

$getdriver = "SELECT * FROM request_header WHERE id = $hid";
$getdriver = $conn2->query($getdriver);
if($getdriver->num_rows > 0){
$row = mysqli_fetch_assoc($getdriver);

$driver_id = $row["assigned_driver"];

$insert_rating = "INSERT INTO driver_rating (request_id, driver_id, rating) VALUES($hid, $driver_id, $rating)";
$insert_rating = $conn2->query($insert_rating);
if(!$insert_rating){
    echo mysqli_error($conn2);
}else{
    echo $rating;
}
}else{
    echo $hid;
}