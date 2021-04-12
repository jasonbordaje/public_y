<?php
include '../includes/dbconfig2.php';
header('Access-Control-Allow-Origin: *');

session_start();
$hid = $_SESSION['headerid'];
$rating = $_REQUEST['rating'];

$requested = "SELECT * FROM request_header WHERE id = $hid";
$requested = $conn2->query($requested);
if($requested->num_rows > 0){
$row = mysqli_fetch_assoc($requested);

$requested_by = $row["requested_by"];

$insert_rating = "INSERT INTO customer_rating (request_id, customer_id, rating) VALUES($hid, $requested_by, $rating)";
$insert_rating = $conn2->query($insert_rating);
if(!$insert_rating){
    echo mysqli_error($conn2);
}else{
    echo $rating;
}
}else{
    echo $hid;
}